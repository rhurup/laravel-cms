<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\NotFoundException;
use App\Http\Responses\JsonResponse;
use App\Models\Acl\AclPermission;
use App\Models\Acl\AclRole;
use App\Utilities\DataTablesUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Admin
 *
 * API endpoints for Shops all required authenticated user - 'Authorization' => 'Bearer {api_token}'
 */
class RolesController extends Controller
{
    public $PermissionGroup = 'roles';


    /**
     * admin/roles
     *
     * List all roles
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function index(Request $request)
    {
        $this->init('browse');

        $filters = DataTablesUtil::fromInput($request);

        $recordsTotal = AclRole::all()->count();
        $recordsFiltered = AclRole::withDatatablesFilter($filters, false)->count();
        $roles = AclRole::withDatatablesFilter($filters)->with("permissions")->withCount(['users'])->get();

        return (new JsonResponse($roles))
            ->add("recordsTotal", $recordsTotal)
            ->add("recordsFiltered", $recordsFiltered);
    }


    /**
     * admin/roles/{id}
     *
     * Show a role
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function show(Request $request, $id)
    {
        $this->init('update');

        $role = AclRole::with('permissions')->find($id);

        if (!$role) {
            throw new NotFoundException('Role not found');
        }

        return new JsonResponse($role);
    }


    /**
     * admin/roles/{id}/permissions
     *
     * Show the permissions of a given role
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function show_permissions(Request $request, $id)
    {
        $this->init('browse');

        $role = AclRole::find($id);

        if (!$role) {
            throw new NotFoundException('Role not found');
        }

        return new JsonResponse($role->permissions);
    }


    /**
     * admin/roles/permissions
     *
     * Show all permissions
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function all_permissions(Request $request)
    {
        $this->init('browse');

        $permissions = AclPermission::all();

        if (!$permissions) {
            throw new NotFoundException('Permissions not found');
        }

        return new JsonResponse($permissions);
    }


    /**
     * roles
     *
     * Create a new role
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function store(Request $request, $id)
    {
        $this->init('create');

        $role = new AclRole();
        $role->fill($request->all());
        $role->save();

        return new JsonResponse($role);
    }


    /**
     * roles/{id}
     *
     * Update any given role
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function update(Request $request, $id)
    {
        $this->init('update');

        $role = AclRole::find($id);

        if (!$role) {
            throw new NotFoundException('Role not found');
        }

        $role->fill($request->all());
        $role->save();

        if(!$request->post("permissions", false)){
            return new JsonResponse($role);
        }

        $newPermissions     = $request->post("permissions", false);
        $role->setPermissions($newPermissions);

        return new JsonResponse($role);
    }


    /**
     * admin/roles/{id}
     *
     * Delete any given role and unset all permissions from it
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function destroy(Request $request, $id)
    {
        $this->init('delete');

        $role = AclRole::find($id);

        if (!$role) {
            throw new NotFoundException('Role not found');
        }

        $role->delete();

        return new JsonResponse($role);
    }
}
