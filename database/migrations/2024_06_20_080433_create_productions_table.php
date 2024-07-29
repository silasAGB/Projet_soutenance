<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id('id_production');
            $table->date('date_prevue');
            $table->integer('qte_prevue');
            $table->integer('qte_produite');
            $table->date('date_production');
            $table->float('montant_produit');
            $table->string('statut');
            $table->timestamps();

            $table->unsignedBigInteger('id_Produit');
            $table->foreign('id_Produit')->references('id_Produit')->on('produits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productions');
    }
}
