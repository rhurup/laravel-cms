<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\JsonResponse;
use App\Mail\RegistrationVerification;
use App\Mail\ResetPassword;
use App\Models\Users\User;
use App\Models\Users\UserResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * @group Authentication
 *
 * API endpoints for user authentication - Authenticated request requires a 'Authorization' => 'Bearer {api_token}'
 *
 *
 */
class AuthController extends Controller
{
    public $PermissionGroup = 'user';

    /**
     * register
     *
     * Creating a normal user
     *
     * @bodyParam email string required The email of the user.
     * @bodyParam password string required The password of the user.
     * @bodyParam password_confirmation string required The password retyped of the user.
     * @bodyParam name string The name of the user.
     * @response { "status": 200, "message": "Du er nu registreret til kunde portal. Tjek venligst din email for verificerings link", "data": {"verify_token":"....."} }
     * @response 401 {"status": 401,"message": "Incorrect post data","data": {} }
     * @response 402 {"status": 402,"message": "Incorrect password data","data": {} }
     * @response 403 {"status": 403,"message": "Incorrect password match","data": {} }
     */
    public function register(Request $request)
    {
        $this->init("register");

        if (!$request->post("email", false)) {
            return new JsonResponse(new \stdClass(), 401, __('users.password_invalid'));
        }

        if (!$request->post("password", false) && !$request->post("password_confirmation", false)) {
            return new JsonResponse(new \stdClass(), 402, __('users.password_invalid'));
        }

        if ($request->post("password", false) !== $request->post("password_confirmation", false)) {
            return new JsonResponse(new \stdClass(), 403, __("users.password_incorrect_match"));
        }

        $email = $request->post('email');
        $name = $request->post('name', '');

        $UserExists = User::where("email", $email)->count();
        if ($UserExists > 0) {
            return new JsonResponse(new \stdClass(), 403, __("users.email_already_exists"));
        }

        $vToken = Str::random(64);
        $rToken = Str::random(64);
        $aToken = Str::random(64);

        $User = new User();

        $User->email = $email;
        $User->name = $name;

        $User->password = Hash::make($request->post('password'));
        $User->api_token = $aToken;
        $User->remember_token = $rToken;
        $User->email_verified_token = $vToken;
        $User->save();

        $User->addRole("2");

        Mail::to($email)->send(new RegistrationVerification($name, $vToken));

        return new JsonResponse(['verify_token' => $vToken], 200, __('users.registration_success'));
    }


    /**
     * login
     *
     * Log in as normal user
     *
     * @bodyParam email string required The email of the user.
     * @bodyParam password string required The password of the user.
     * @response 200 {"status": 200, "message": "Du er nu registreret til kunde portal. Venligst få ind i din e-mail og verificer!", "data": {"token":"OK"} }
     * @response 401 {"status": 401,"message": "Incorrect post data","data": {} }
     * @response 402 {"status": 402,"message": "Brugernavn eller password er forkert, prøv venligst igen!","data": {} }
     * @response 403 {"status": 403,"message": "Kontoen er ikke bekræftet!","data": {} }
     */
    public function login(Request $request)
    {
        $this->init("login");

        if (!$request->post("email", false) && !$request->post("password", false)) {
            return new JsonResponse([], 401, "Incorrect post data");
        }

        $credentials = array(
            'email' => $request->post("email", false),
            'password' => $request->post("password", false)
        );
        $remember = true;

        if (!Auth::attempt($credentials, $remember)) {
            return new JsonResponse(new \stdClass(), 402, "Brugernavn eller password er forkert, prøv venligst igen!");
        }

        if (Auth::user()->email_verified_at === null) {
            $vToken = Str::random(64);
            $rToken = Str::random(64);
            $aToken = Str::random(64);

            $User = User::find(Auth::user()->id);
            $User->email_verified_token = $vToken;
            $User->api_token = $aToken;
            $User->remember_token = $rToken;
            $User->save();
            Auth::logout();

            Mail::to($User->email)->send(new RegistrationVerification($User->name, $vToken));
            return new JsonResponse(new \stdClass(), 403, "Kontoen er ikke bekræftet! Ny verificerings email sendt.");
        }

        $User = User::find(Auth::user()->id);
        $User->logged_in_at = Carbon::now()->format("Y-m-d H:i:s");
        $User->save();

        return new JsonResponse(['api_token' => $User->api_token]);
    }


    /**
     * logout
     *
     * Logout a user
     *
     * @authenticated
     * @response { "status": 200, "message": "", "data": {} }
     */
    public function logout(Request $request)
    {
        $this->init("logout");

        $aToken = Str::random(64);
        $User = User::find(Auth::user()->id);
        $User->api_token = $aToken;
        $User->save();

        return new JsonResponse(new \stdClass());
    }


    /**
     * verify-email
     *
     * Verify email token after user is created
     *
     * @bodyParam token string required The email token of the user.
     * @response 200 {"status": 200, "message": "Your now verified", "data": {"token":"OK"} }
     * @response 401 {"status": 401,"message": "No token data","data": {} }
     * @response 402 {"status": 402,"message": "We couldnt find your token.","data": {} }
     * @response 403 {"status": 403,"message": "Your already verified","data": {} }
     */
    public function verifyEmail(Request $request)
    {
        $this->init("verify-email");

        if (!$request->post("token", false)) {
            return new JsonResponse(new \stdClass(), 401, "Ingen verificerings nøglen fundet");
        }
        $token = $request->post("token", false);

        $User = User::where('email_verified_token', $token)->first();

        if (!$User) {
            return new JsonResponse(new \stdClass(), 402, "Vi kunne ikke finde verificerings nøglen");
        }

        if ($User->verified_at !== null) {
            return new JsonResponse(new \stdClass(),  403, "Du er allerede verificeret");
        }

        $User->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");
        $User->save();

        return new JsonResponse(new \stdClass(), 200, 'Du er nu verificeret');
    }


    /**
     * send-reset-password-link
     *
     * Send reset password email
     *
     * @bodyParam email string required The email token of the user.
     * @response 200 {"status": 200, "message": "Nulstilling af kode link er sendt til din email.", "data": {"token":"OK"} }
     * @response 401 {"status": 401,"message": "No email provided","data": {} }
     * @response 402 {"status": 402,"message": "No correct email provided","data": {} }
     */
    public function sendResetPasswordLink(Request $request)
    {
        $this->init('send-reset-password-link');

        if (!$request->post('email', false)) {
            return new JsonResponse(new \stdClass(), 401,  __('users.email_dont_exist'));
        }

        $User = User::where(["email" => $request->get('email')])->first();

        if (!$User) {
            return new JsonResponse(new \stdClass(), 402,  __('users.email_dont_exist'));
        }

        $pwToken = Str::random(64);

        $PasswordReset = $User->ResetPassword()->updateOrCreate(
            [
            'email' => $User->email
            ],
            [
            'token' => $pwToken,
            'created_at' => Carbon::now()->format("Y-m-d H:i:s"),
            ]
        );

        Mail::to($User->email)
            ->send(new ResetPassword($User->name, $PasswordReset->token));

        return new JsonResponse(['reset_token' => $PasswordReset->token], 200, 'Nulstilling af kode link er sendt til din email.');
    }


    /**
     * confirm-reset-password-link
     *
     * Confirm reset password email token
     *
     * @bodyParam token string required The email token of the user.
     * @bodyParam newpassword string required The new password token for the user.
     * @response 200 {"status": 200, "message": "Password er blevet ændret. Du kan logge ind nu!", "data": {"api_token":"....."} }
     * @response 401 {"status": 401,"message": "No token provided","data": {} }
     * @response 402 {"status": 402,"message": "No correct email provided","data": {} }
     * @response 403 {"status": 403,"message": "No token is available","data": {} }
     */
    public function confirmResetPassword(Request $request)
    {
        $this->init('confirm-reset-password-link');

        if (!$request->post('token', false)) {
            return new JsonResponse(new \stdClass(), 401, "No token provided");
        }
        if (!$request->post('newpassword', false)) {
            return new JsonResponse(new \stdClass(), 402, "No new password provided");
        }

        $UserResetPassword = UserResetPassword::where('token', $request->post('token'))->first();
        if ($UserResetPassword == null) {
            return new JsonResponse(new \stdClass(), 403, "No token is available, try send reset email again");
        }

        $User = User::where("email", $UserResetPassword->email)->first();

        $User->password = Hash::make($request->post('newpassword'));
        $User->save();

        return new JsonResponse(['api_token' => $User->api_token], 200, "Password er blevet ændret. Du kan logge ind nu!");
    }
}
