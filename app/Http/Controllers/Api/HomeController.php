<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\Api\ApiNotFoundException;
use App\Http\Controllers\Controller;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fallback()
    {
        throw new ApiNotFoundException;
    }
}
