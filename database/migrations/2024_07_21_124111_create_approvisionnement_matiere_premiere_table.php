<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovisionnementMatierePremiereTable extends Migration
{
    public function up()
    {
        Schema::create('approvisionnement_matiere_premiere', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_approvisionnement');
            $table->unsignedBigInteger('id_MP');
            $table->unsignedBigInteger('id_fournisseur');
            $table->integer('qte_approvisionnement');
            $table->decimal('montant', 10, 2);
            $table->string('statut')->default('en attente'); // Nouveau champ pour le statut
            $table->integer('qte_livree')->nullable(); // Nouveau champ pour la quantité livrée
            $table->date('date_livraison')->nullable(); // Nouveau champ pour la date de livraison
            $table->timestamps();

            // Clés étrangères
            $table->foreign('id_approvisionnement')->references('id_approvisionnement')->on('approvisionnements')->onDelete('cascade');
            $table->foreign('id_MP')->references('id_MP')->on('matiere_premieres');
            $table->foreign('id_fournisseur')->references('id_fournisseur')->on('fournisseurs');

        });
    }

    public function down()
    {
        Schema::dropIfExists('approvisionnement_matiere_premiere');

        Schema::table('approvisionnement_matiere_premiere', function (Blueprint $table) {
            $table->unique(['id_approvisionnement', 'id_MP']);
        });
    }
}
