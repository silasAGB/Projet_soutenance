<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('id_commande');
            $table->string('reference_commande')->unique();
            $table->date('date_commande');
            $table->float('montant');
            $table->string('statut');
            $table->string('adresse_livraison');
            $table->date('date_livraison');
            $table->timestamps();

            // Client associé à la commande (peut être null si aucun client n'est sélectionné)
            $table->unsignedBigInteger('id_client')->nullable();
            $table->foreign('id_client')->references('id_client')->on('clients')->onDelete('set null');

            // Utilisateur connecté qui effectue la commande
            $table->unsignedBigInteger('id_utilisateur');
            $table->foreign('id_utilisateur')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropForeign(['id_client']);
            $table->dropForeign(['id_utilisateur']);
        });

        Schema::dropIfExists('commandes');
    }
}
