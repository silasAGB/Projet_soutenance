<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributeursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributeurs', function (Blueprint $table) {
            $table->id('id_Distributeur');
            $table->timestamps();

            $table->unsignedBigInteger('id_Client');
            $table->foreign('id_Client')->references('id_Client')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributeurs');
    }
}
