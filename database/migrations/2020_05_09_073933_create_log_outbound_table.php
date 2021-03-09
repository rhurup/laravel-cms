<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogOutboundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_outbound', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('resource', 255)->default('');
            $table->string('url', 255)->default('');
            $table->string('method', 50)->default('');
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->integer('response_code')->default(0);
            $table->decimal('response_time', 10, 4)->default(0);
            $table->string('response_error', 255)->default('');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_outbound');
    }
}
