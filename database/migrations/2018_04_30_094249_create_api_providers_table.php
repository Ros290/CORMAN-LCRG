<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('host');
            $table->integer('id_app');
            $table->string('secret_app',250);
            $table->rememberToken();
            $table->boolean('isOn')->default('0');
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
        Schema::dropIfExists('api_providers');
    }
}
