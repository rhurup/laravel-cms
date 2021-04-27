<?php

namespace App\Models\Acl;

use App\Models\BaseModel;
use App\Models\Users\User;
use App\Traits\DataTables;

class AclPermission extends BaseModel
{
    use DataTables;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'acl_permissions';

    /**
     * @var array
     */
    protected $fillable = [
        'group',
        'key',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    public $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];


    /**
     * Get the roles this permission exists in
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AclRole::class, AclPermissionRole::class, 'permission_id', 'role_id');
    }
}
