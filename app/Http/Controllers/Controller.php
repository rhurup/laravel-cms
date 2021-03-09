<?php

namespace App\Http\Controllers;

use App\Exceptions\Laravel\AuthenticationException;
use App\Models\Acl\AclRole;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public $authed = null;


    /**
     * @var \App\Models\Users\User|null
     */
    public $user = null;

    /**
     * @var int|null User Id for public users for public endpoints
     */
    public $publicUserId = 1;

    /**
     * Init common ressources for controllers
     *
     * @param String|null $RequirePermission
     * @param String|null $PermissionGroup
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function init(String $RequirePermission = null, String $PermissionGroup = null)
    {
        // Grab the authorized user and store it for now.
        // We use Auth::guard('api') instead of Auth::user(), because:
        // - Auth::user() is not resolved on routes without middleware auth:api
        // - These route may STILL use a valid api_token
        // - Auth::guard('api') takes api_token into consideration
        if(Auth::guard('web')->user() !== null){
            $this->authed = Auth::guard('web')->user();
        }else if(Auth::guard('api')->user() !== null){
            $this->authed = Auth::guard('api')->user();
        }

        // If request is authed by guard, we can find a fresh user object in cache
        if ($this->authed) {
            if (!$this->user = User::find($this->authed->id)) {
                throw new AuthenticationException('Invalid token supplied');
            }

            // However - If this route is run without middleware auth:api, we must log in user manually
            if (!Auth::user()) {
                Auth::onceUsingId($this->user->id);
            }
        }
        else {
            // Even though we're not in a request protected by auth:api, there might still be used a token
            // which could resolve to a valid user. Check that
            $header = request()->headers->get('Authorization', '');
            $token = (Str::startsWith($header, 'Bearer ') ? $token = Str::substr($header, 7) : false);

            if ($token) {
                if ($this->user = User::where('api_token', '=', $token)->first()){
                    Auth::onceUsingId($this->user->id);
                }
            }else if ($this->publicUserId) {
                // Else, we can use a public user
                if ($this->user = User::find($this->publicUserId)) {
                    Auth::onceUsingId($this->user->id);
                }
            }
        }

        // Verify role(s) for any [authorized] user?
        if ($RequirePermission !== null) {
            $this->requirePermission($RequirePermission, $PermissionGroup);
        }
    }


    /**
     * Require the current user to be authorized for a given permission
     *
     * @param String|null $RequirePermission
     * @param String|null $PermissionGroup
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function requirePermission(String $RequirePermission = null, String $PermissionGroup = null)
    {
        // Get the intended RoleGroup
        if ($PermissionGroup === null) {
            $PermissionGroup = $this->PermissionGroup ?? null;
        }

        // Compile role, (with separator if both prefix and role)
        $Permission = strtolower($PermissionGroup . ($PermissionGroup && $RequirePermission ? '.' : '') . $RequirePermission);

        // Check if user is authorized
        $this->authorize($Permission);
    }


    protected function requireRole($RoleName)
    {
        if (!$this->user) {
            throw new AuthenticationException;
        }

        $Roles = AclRole::all();

        if (!$Roles) {
            throw new AuthenticationException;
        }

        $hasRole = false;
        foreach($Roles as $Role){
            if ($this->user->hasRole($Role->name)) {
                $hasRole = true;
            }
        }
        if (!$hasRole) {
            throw new AuthenticationException;
        }
    }
}
