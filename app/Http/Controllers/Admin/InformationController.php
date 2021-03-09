<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Services\RequirementsService;

class InformationController extends Controller
{
    public $PermissionGroup = 'settings';
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
        $SystemRequirements = new RequirementsService();

        return view('admin.information.index', ['requirements' => $SystemRequirements]);
    }
}
