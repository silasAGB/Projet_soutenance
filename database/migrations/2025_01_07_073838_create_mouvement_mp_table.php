<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMouvementMpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mouvement_mp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_MP')->constrained('matiere_premieres')->onDelete('cascade');
            $table->enum('type', ['entrée', 'sortie']);
            $table->integer('quantité');
            $table->integer('stock_disponible');
            $table->date('date_mouvement');
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
        Schema::dropIfExists('mouvement_mp');
    }
}
