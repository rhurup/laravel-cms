<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("avatar", 255)->after('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string("email_verified_token", 255)->nullable();
            $table->string("api_token", 255)->after('remember_token');

            $table->integer("language_id")->default(0)->after('password');
            $table->integer("timezone_id")->default(0)->after('password');
            $table->timestamp("logged_in_at")->nullable();
            $table->softDeletes();
            $table->bigInteger("deleted_by")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
