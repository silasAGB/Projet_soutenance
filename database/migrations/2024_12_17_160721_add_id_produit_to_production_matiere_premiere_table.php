<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdProduitToProductionMatierePremiereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_matiere_premiere', function (Blueprint $table) {
            $table->unsignedBigInteger('id_produit')->after('id_MP');
            $table->foreign('id_produit')->references('id_produit')->on('produits')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('production_matiere_premiere', function (Blueprint $table) {
            $table->dropForeign(['id_produit']);
            $table->dropColumn('id_produit');
        });
    }
}
