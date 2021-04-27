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
 * API endpoints for Permissions all required authenticated user - 'Authorization' => 'Bearer {api_token}'
 */
class PermissionsController extends Controller
{
    public $PermissionGroup = 'permissions';


    /**
     * admin/permissions
     *
     * List all permissions
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function index(Request $request)
    {
        $this->init('browse');

        $filters = DataTablesUtil::fromInput($request);

        $recordsTotal = AclPermission::all()->count();
        $recordsFiltered = AclPermission::withDatatablesFilter($filters, false)->count();
        $roles = AclPermission::withDatatablesFilter($filters)->get();

        return (new JsonResponse($roles))
            ->add("recordsTotal", $recordsTotal)
            ->add("recordsFiltered", $recordsFiltered);
    }


    /**
     * admin/permissions/{id}
     *
     * Show a permission
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function show(Request $request, $id)
    {
        $this->init('update');

        $role = AclPermission::find($id);

        if (!$role) {
            throw new NotFoundException('Permission not found');
        }

        return new JsonResponse($role);
    }


    /**
     * permission
     *
     * Create a new permission
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function store(Request $request)
    {
        $this->init('create');

        $role = new AclPermission();
        $role->fill($request->all());
        $role->save();

        return new JsonResponse($role);
    }


    /**
     * permissions/{id}
     *
     * Update any given permission
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function update(Request $request, $id)
    {
        $this->init('update');

        $permission = AclPermission::find($id);

        if (!$permission) {
            throw new NotFoundException('Permission not found');
        }

        $permission->fill($request->all());
        $permission->save();

        return new JsonResponse($permission);
    }


    /**
     * admin/permission/{id}
     *
     * Delete any given permission
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"id":"....."} }
     * @response 401 {"status": 401,"message": "Unauthorized access","data": {} }
     */
    public function destroy(Request $request, $id)
    {
        $this->init('delete');

        $permission = AclPermission::find($id);

        if (!$permission) {
            throw new NotFoundException('Role not found');
        }

        $permission->delete();

        return new JsonResponse($permission);
    }
}
