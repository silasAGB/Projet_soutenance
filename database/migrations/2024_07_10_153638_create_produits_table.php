<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('produits', function (Blueprint $table) {
        $table->id('id_produit');
        $table->string('reference_produit');
        $table->string('nom_produit');
        $table->text('description_produit')->nullable();
        $table->decimal('prix_details_produit', 8, 2);
        $table->decimal('prix_gros_produit', 8, 2)->nullable();
        $table->integer('qte_preparation')->default(0);
        $table->integer('qte_lot')->nullable();
        $table->integer('qte_stock');
        $table->integer('stock_min')->nullable();
        $table->string('emplacement')->nullable();
        $table->unsignedBigInteger('id_categorie');
        $table->timestamps();

        $table->foreign('id_Categorie')->references('id_Categorie')->on('categories');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
}
