<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string("country");
            $table->string("code", 50);
            $table->string("iso_code", 50);
            $table->tinyInteger("active")->default(0);
            $table->tinyInteger("phone_code")->default(0);
            $table->string("currency_code", 50)->default('');
            $table->string("currency_name", 50)->nullable()->default('');
            $table->string("currency_symbol", 50)->nullable()->default('');
            $table->string("currency_align", 50)->nullable()->default('');
            $table->string("dec_point", 50)->nullable()->default('');
            $table->string("thousands_sep", 50)->nullable()->default('');
            $table->string("iso_639_1", 50)->nullable()->default('');
            $table->string("iso_639_2t", 50)->nullable()->default('');
            $table->string("iso_639_2b", 50)->nullable()->default('');
            $table->string("iso_639_3", 50)->nullable()->default('');
            $table->string("iso_639_6", 50)->nullable()->default('');

            $table->timestamps();
            $table->integer("created_by")->default(0);
            $table->integer("updated_by")->default(0);
            $table->softDeletes();
            $table->integer("deleted_by")->default(0);
        });

        Schema::create('countries_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string("lang", 50);
            $table->string("langType", 50);

            $table->timestamps();
            $table->integer("created_by")->default(0);
            $table->integer("updated_by")->default(0);
            $table->softDeletes();
            $table->integer("deleted_by")->default(0);
        });

        Schema::create('countries_zones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string("zone_name", 50);

            $table->timestamps();
            $table->integer("created_by")->default(0);
            $table->integer("updated_by")->default(0);
            $table->softDeletes();
            $table->integer("deleted_by")->default(0);
        });

        Schema::create('countries_zones_timezone', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("zone_id");
            $table->foreign('zone_id')->references('id')->on('countries_zones');

            $table->string("abbreviation", 50);
            $table->decimal("time_start", 11,0);
            $table->integer("gmt_offset");
            $table->string("dst", 50);

            $table->timestamps();
            $table->integer("created_by")->default(0);
            $table->integer("updated_by")->default(0);
            $table->softDeletes();
            $table->integer("deleted_by")->default(0);
        });

        $countries_path = base_path('database/migrations_sql/countries_08-05-2020.sql');
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($countries_path));

        $countries_languages_path = base_path('database/migrations_sql/countries_languages_08-05-2020.sql');
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($countries_languages_path));

        $countries_zones_path = base_path('database/migrations_sql/countries_zones_08-05-2020.sql');
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($countries_zones_path));

        $countries_zones_timezone_path = base_path('database/migrations_sql/countries_zones_timezone_08-05-2020.sql');
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($countries_zones_timezone_path));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries_related_tables');
    }
}
