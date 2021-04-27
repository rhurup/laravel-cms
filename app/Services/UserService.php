<?php


namespace App\Services;

use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserService
{

    public function __construct()
    {

    }

    public static function AuthSocialUser($email, $params){
        $foundUser = User::where("email", $email)->first();

        if($foundUser){
            $user = $foundUser;
            $user->found = true;
        }else{
            $uObj = [];
            $uObj['email'] = $email;

            foreach($params as $pKey => $pValue){
                if(in_array($pKey, ['password', 'api_token'])){
                    $uObj[$pKey] = Hash::make($pValue);
                }else{
                    $uObj[$pKey] = $pValue;
                }
            }

            $user = User::create($uObj);
            $user->found = false;
        }

        return $user;

    }
    public static function GuardSocialUser($user, $password)
    {
        if($user){
            if($user->found){
                if(Auth::loginUsingId($user->id)){
                    return Redirect::route('web_dashboard');
                }else{
                    return Redirect::route('web_home', ["error" => "Login failed using id"]);
                }
            }else{
                if (Auth::attempt(['email' => $user->email, 'password' => $password])) {
                    return Redirect::route('web_dashboard');
                }else{
                    return Redirect::route('web_home', ["error" => "Login attempt failed"]);
                }
            }
        }else{
            return Redirect::route('web_home', ["error" => "No user found"]);
        }
    }
}
