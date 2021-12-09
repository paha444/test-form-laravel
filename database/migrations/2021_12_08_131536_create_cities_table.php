<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            //$table->timestamps();
            
            //$table->increments('id');


            $table->unsignedBigInteger('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->unsignedBigInteger('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions');
            
            //$table->integer('id_region')->unsigned();
            //$table->integer('id_country')->unsigned();
                        
            $table->string('name');            
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city');
    }
}
