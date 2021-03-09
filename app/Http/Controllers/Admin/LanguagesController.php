<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public $PermissionGroup = 'languages';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Countries index view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->init("browse");

        return view('admin.languages.index');
    }

    /**
     * Country view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id)
    {
        $this->init("update");

        return view('admin.languages.show', ['id' => $id]);
    }

}
