<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->string('TTN')->nullable();
            
            //$table->enum('Status', ['1_prepared_shipment_spss', '2_sent_to_spss', '3_prepared_shipment', '4_sent'])->nullable();
            
            $table->integer('Status')->default(0)->unsigned();
            
            $table->string('Sender')->nullable();
            $table->string('Recipient')->nullable();

            $table->string('Sender_city')->nullable();
            $table->string('Recipient_city')->nullable();
            
            
            
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
        Schema::dropIfExists('packages');
    }
}
