<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\Api\ApiNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Responses\JsonResponse;
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
        return (new JsonResponse([]));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fallback()
    {
        throw new ApiNotFoundException;
    }
}
