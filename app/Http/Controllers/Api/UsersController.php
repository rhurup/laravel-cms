<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\ApiNotFoundException;
use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\UsersNotFoundException;
use App\Http\Responses\JsonResponse;
use App\Models\Acl\AclRole;
use App\Models\Users\User;
use App\Models\Users\UserEmails;
use App\Services\Models\UserService;
use App\Utilities\DataTablesUtil;
use Carbon\Carbon;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @group Users
 *
 * API endpoints for user - Authenticated request requires a 'Authorization' => 'Bearer {api_token}'
 *
 *
 */
class UsersController extends Controller
{
    public $PermissionGroup = 'users';


    /**
     * me
     *
     * Get info for the user of the current api token
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function me(Request $request)
    {
        $this->init('show','user');

        $userObj = new \StdClass();
        $userObj->user = clone $this->user;
        $userObj->role = $this->user->role->load('permissions');

        return new JsonResponse($userObj);
    }

    /**
     * users/{id}
     *
     * Update info on the user of the current api token
     *
     * @bodyParam name string Example: John Doe
     * @bodyParam password string
     * @bodyParam password_confirmation string
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function update(Request $request, $id)
    {
        $this->init('update', 'user');

        // Load user
        $user = User::find($id);

        // Are we creating or altering someone else?
        if ($this->user->id != $id) {
            $this->requirePermission('update');
        }
        $formData = $request->all();
        // Update user
        {

            if(isset($formData['newpassword'])){
                $password = $formData['newpassword'];
                if ($password) {
                    $formData['password'] = bcrypt($password);
                }
            }

            if (!empty($formData)) {
                $user = User::updateOrCreate(['id' => $user->id], $formData);
            }
            if(isset($formData['roles'])){
                if ($this->user->id != $id) {
                    $this->requirePermission('update');
                    $user->setRoles($formData['roles']);
                }
            }
        }

        return new JsonResponse($user);
    }

    /**
     * users
     *
     * Get info for the user of the current api token
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function index(Request $request)
    {
        $this->init('browse');

        $filters = DataTablesUtil::fromInput($request);

        $recordsTotal = User::all()->count();
        $recordsFiltered = User::withDatatablesFilter($filters, false)->count();
        $users = User::withDatatablesFilter($filters)->with(['roles','timezone','language'])->get();

        return (new JsonResponse($users))
            ->add("recordsTotal", $recordsTotal)
            ->add("recordsFiltered", $recordsFiltered);
    }
    /**
     * users
     *
     * store user
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function store(Request $request)
    {
        $this->init('create');

        if(!$request->post("email", false)){
            throw new NotFoundException("Email not found", 404);
        }
        if(!$request->post("newpassword", false)){
            throw new NotFoundException("Email not found", 404);
        }
        if(!$request->post("role_id", false)){
            throw new NotFoundException("Role not found", 404);
        }

        if(!$request->post("timezone_id", false)){
            throw new NotFoundException("Timezone not found", 404);
        }

        if(!$request->post("language_id", false)){
            throw new NotFoundException("Language not found", 404);
        }

        $UserExists = User::where("email", $request->post("email", false))->count();
        if ($UserExists > 0) {
            throw new InvalidArgumentException("User already exists", 403);
        }

        $vToken = Str::random(64);
        $rToken = Str::random(64);
        $aToken = Str::random(64);

        $NewUser = new User();
        $NewUser->name = $request->post("name", '');
        $NewUser->email = $request->post("name", '');
        $NewUser->timezone_id = $request->post("timezone_id", '');
        $NewUser->language_id = $request->post("language_id", '');
        $NewUser->password = Hash::make($request->post('password'));
        $NewUser->api_token = $aToken;
        $NewUser->remember_token = $rToken;
        $NewUser->email_verified_token = $vToken;
        $NewUser->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");

        $NewUser->save();

        $NewUser->addRole($request->post("role_id", 2));

        return new JsonResponse($NewUser);
    }

    /**
     * users/{id}
     *
     * Get info for the user
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function show(Request $request, $id)
    {
        $this->init('browse');

        $user = User::with(['roles.permissions','language','timezone'])->find($id);

        return new JsonResponse($user);
    }
    /**
     * users/{id}
     *
     * Delete user
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function destroy(Request $request, $id)
    {
        $this->init('delete');

        $user = User::find($id);
        $user->delete();

        return new JsonResponse([]);
    }

}
