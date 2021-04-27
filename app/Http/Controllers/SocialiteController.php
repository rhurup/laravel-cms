<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    /**
     * Authenticating Github user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function github_login(Request $request)
    {
        return Socialite::driver('github')->redirect();
    }


    /**
     * Redirecting Github user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function github_redirect(Request $request)
    {
        $user       = false;
        $password   = false;

        $gUser = Socialite::driver('github')->user();
        if(property_exists($gUser, "token") && property_exists($gUser, "email")){
            $password = $gUser->id;
            $user = UserService::AuthSocialUser($gUser->email, [
                    'name' => $gUser->nickname,
                    'password' => $password,
                    'api_token' => $gUser->nickname,
                ]
            );
        }

        return UserService::GuardSocialUser($user, $password);
    }


    /**
     * Deleting Github user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function github_deletion(Request $request)
    {


    }



    /**
     * Authenticating Facebook user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function facebook_login(Request $request)
    {
        return Socialite::driver('facebook')->redirect();
    }


    /**
     * Redirecting Facebook user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function facebook_redirect(Request $request)
    {
        $user = false;
        $fUser = Socialite::driver('facebook')->user();
        if(property_exists($fUser, "token") && property_exists($fUser, "email")){
            $password = $fUser->id;
            $user = UserService::AuthSocialUser($fUser->email, [
                    'name' => $fUser->name,
                    'password' => $password,
                    'api_token' => $fUser->token,
                ]
            );
        }

        return UserService::GuardSocialUser($user, $password);

    }


    /**
     * Deleting Facebook user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function facebook_deletion(Request $request)
    {


    }


    /**
     * Authenticating Google user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function google_login(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }


    /**
     * Redirecting Google user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function google_redirect(Request $request)
    {
        $user = false;
        $gUser = Socialite::driver('google')->user();
        if(property_exists($gUser, "token") && property_exists($gUser, "email")){
            $password = $gUser->id;
            $user = UserService::AuthSocialUser($gUser->email, [
                    'name' => $gUser->name,
                    'password' => $password,
                    'api_token' => $gUser->token,
                ]
            );
        }

        return UserService::GuardSocialUser($user, $password);

    }


    /**
     * Deleting Google user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function google_deletion(Request $request)
    {


    }
}
