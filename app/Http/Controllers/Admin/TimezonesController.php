<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimezonesController extends Controller
{
    public $PermissionGroup = 'timezones';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Timezones index view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->init("browse");

        return view('admin.timezones.index');
    }

    /**
     * Timezone view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id)
    {
        $this->init("update");

        return view('admin.timezones.show', ['id' => $id]);
    }

}
