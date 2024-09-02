<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionsTable extends Migration
{
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id('id_production');
            $table->string('reference_production')->unique();
            $table->string('nom_production');
            $table->date('date_prevue');
            $table->integer('qte_prevue');
            $table->integer('qte_produite')->nullable();
            $table->integer('nbr_preparation');
            $table->date('date_production')->nullable();
            $table->float('montant_produit')->nullable();
            $table->string('statut');
            $table->timestamps();

            $table->unsignedBigInteger('id_Produit');
            $table->foreign('id_Produit')->references('id_produit')->on('produits')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('productions');
    }
}


