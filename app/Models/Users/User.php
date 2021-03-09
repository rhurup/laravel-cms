<?php

namespace App\Models\Users;

use App\Models\Countries\CountriesLanguages;
use App\Models\Countries\CountriesZones;
use App\Traits\DataTables;
use App\Traits\ModelActionsBy;
use App\Traits\ModelHelpers;
use App\Traits\UserAccess;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, ModelHelpers, ModelActionsBy, UserAccess, DataTables;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'avatar',
        'password',
        'remember_token',
        'api_token',
        'timezone_id',
        'language_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'logged_in_at' => 'datetime',
    ];

    protected $attributes = [
        'avatar' => 'images/avatar_default.png'
    ];

    public function ResetPassword(){
        return $this->hasOne(UserResetPassword::class, 'email', 'email');
    }

    public function timezone()
    {
        return $this->hasOne(CountriesZones::class, 'id', 'timezone_id');
    }

    public function language()
    {

        return $this->hasOne(CountriesLanguages::class, 'id', 'language_id');
    }
}
