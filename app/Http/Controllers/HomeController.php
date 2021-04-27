<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $default_view = Settings::getValue('default.frontend_view');

        return view($default_view);
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {

        return view("frontend.dashboard");
    }

}
