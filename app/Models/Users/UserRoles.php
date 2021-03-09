<?php

namespace App\Models\Users;

use App\Models\Acl\AclRole;
use App\Models\BaseModel;

class UserRoles extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'users_roles';


    protected $fillable = [
        'user_id',
        'role_id',
    ];



    /**
     * Get the user this map belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the role this map belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(AclRole::class);
    }

}
