<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            
            
            
            //$table->increments('id');
            
            $table->unsignedBigInteger('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            
            //$table->integer('id_country')->unsigned();
            
            $table->string('name');
            
            
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region');
    }
}
