<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_commande')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('id_produit')->constrained('produits')->onDelete('cascade');
            $table->integer('qte_produit_commande');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('montant_produit_commande', 10, 2);
            $table->timestamps();


            $table->index('id_commande');
            $table->index('id_produit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produit_commandes');
    }
}
