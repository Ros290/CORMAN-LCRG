<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            /*
             * 'attr_url' definisce il campo in cui deve essere inserito il valore all'interno
             * dell'URL (esempio, data l'opzione Categoria, il valore associato al campo "Titolo"
             * sarà depositato, nell'url, all'interno del campo "title").
             */
            $table->string('attr_url');
            /*
             * 'attr_json' definisce il campo associato all'interno del JSON ricavato dalla ricerca
             * di una data opzione
             */
            $table->string('attr_json');
            $table->boolean('values');
            /*
             * 'id_option' è la chiave secondaria, indirizzata all'opzione quale compone il campo
             * (esempio, l'opzione Profilo è definita dai campi "nome", "cognome", "località", ecc)
             */
            $table->unsignedInteger('id_option');
            $table->foreign('id_option')->references('id')->on('search_options');
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
        Schema::dropIfExists('fields');
    }
}
