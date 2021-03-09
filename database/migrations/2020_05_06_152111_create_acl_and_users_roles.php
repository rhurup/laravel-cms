<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAclAndUsersRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('acl_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('group')->nullable(false);
            $table->string('key')->nullable(false);
            $table->text('description')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger("deleted_by")->default(0);
        });
        Schema::create('acl_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('display_name')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger("deleted_by")->default(0);
        });


        Schema::create('acl_permissions_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->foreign('permission_id')->references('id')->on('acl_permissions');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('acl_roles');
        });

        Schema::create('users_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('role_id')->nullable(false);
            $table->foreign('role_id')->references('id')->on('acl_roles');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
}
