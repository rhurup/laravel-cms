<?php

namespace App\Models\Acl;

use App\Models\BaseModel;

class AclPermissionRole extends BaseModel
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'acl_permissions_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id',
        'role_id',
    ];


    /**
     * Get the permission this map belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(AclPermission::class);
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
