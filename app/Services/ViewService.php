<?php


namespace App\Services;

use Illuminate\Support\Facades\Cookie;

class ViewService
{

    public function __construct()
    {

    }

    public static function isDarkModeVisible()
    {
        $isDarkModeVisible = Cookie::get("isDarkModeVisible");
        if((bool)$isDarkModeVisible){
            return true;
        }
        return false;
    }
    public static function isSidebarVisible()
    {
        $isSidebarVisible = Cookie::get("isSidebarVisible");
        if((bool)$isSidebarVisible){
            return true;
        }
        return false;
    }
}