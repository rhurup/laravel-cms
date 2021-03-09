<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorizonTelescopePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $AdminPermissions = [];
        $AdminPermissions[] = ['group' => 'admin','key' => 'telescope','description' => 'Login in at Telescope'];
        $AdminPermissions[] = ['group' => 'admin','key' => 'horizon','description' => 'Login in at Horizon'];

        $AdminRole = \App\Models\Acl\AclRole::where('name','admin')->first();

        foreach($AdminPermissions as $AdminPermission){
            $permission = \App\Models\Acl\AclPermission::create($AdminPermission);
            $AdminRole->addPermission($permission->id);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horizon_telescope_permissions');
    }
}
