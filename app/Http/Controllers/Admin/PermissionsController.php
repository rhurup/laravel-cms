<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Services\RequirementsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends Controller
{
    public $PermissionGroup = 'roles';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Settings view for settings variables
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->init("browse");

        return view('admin.permissions.index');
    }

    /**
     * Show the user edit.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id)
    {
        $this->init("browse");

        return view('admin.permissions.show', ['id' => $id]);
    }
}
