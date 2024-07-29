<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmallboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smallboxes', function (Blueprint $table) {
            $table->id();
        $table->string('nom');
        $table->integer('quantité');
        $table->string('unité');
        $table->string('type');  // si c'est produit ou si c'est matiere premiere
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
        Schema::dropIfExists('smallboxes');
    }
}
