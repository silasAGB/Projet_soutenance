<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMouvementProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mouvement_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produit')->constrained('produits')->onDelete('cascade');
            $table->enum('type', ['entrée', 'sortie']);
            $table->integer('quantité');
            $table->integer('stock_disponible');
            $table->date('date_mouvement');
            $table->unsignedBigInteger('id_production')->nullable();
            $table->foreign('id_production')->references('id_production')->on('productions')->onDelete('cascade');
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
        Schema::dropIfExists('mouvement_produit');

        Schema::table('mouvement_produit', function (Blueprint $table) {
            $table->dropForeign(['id_production']);
            $table->dropColumn('id_production');
        });
    }
}
