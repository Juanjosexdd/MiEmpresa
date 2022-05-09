<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_home')->nullable();
            $table->string('logo_shop')->nullable();
            $table->string('logo_footer')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('url_fb', 100)->nullable();
            $table->string('url_insta', 100)->nullable();
            $table->string('url_maps', 100)->nullable();
            $table->string('yape', 20)->nullable();
            $table->string('plin', 20)->nullable();
            $table->string('transferencia', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('name_company', 60)->nullable();
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
        Schema::dropIfExists('settings');
    }
}
