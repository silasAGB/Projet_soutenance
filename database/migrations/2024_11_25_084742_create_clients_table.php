<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id_client');

            // Informations personnelles
            $table->string('nom_client'); // Nom
            $table->string('prenom_client'); // Prénom
            $table->date('date_naissance')->nullable(); // Date de naissance
            $table->integer('age')->nullable(); // Âge (calculé ou renseigné)
            $table->enum('sexe', ['Homme', 'Femme', 'Autre'])->nullable(); // Sexe

            // Informations de contact
            $table->string('mail_client')->unique(); // Email
            $table->string('contact_client')->unique(); // Téléphone
            $table->string('adresse_client'); // Adresse

            // Informations professionnelles
            $table->string('nom_entreprise')->nullable(); // Nom de l'entreprise du client
            $table->string('poste_occupe')->nullable(); // Poste occupé
            $table->string('type_entreprise')->nullable(); // Type d'entreprise (ex : Distributeur, Revendeur, etc.)
            $table->string('secteur_activite')->nullable(); // Secteur d'activité de l'entreprise

            // Données administratives
            $table->string('num_identification_fiscale')->nullable(); // Numéro d'identification fiscale
            $table->string('num_registre_commerce')->nullable(); // Numéro de registre du commerce

            // Historique et statut
            $table->string('statut')->default('actif'); // Statut du client (actif, suspendu, etc.)
            $table->dateTime('date_inscription')->nullable(); // Date d'inscription au système

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
        Schema::dropIfExists('clients');
    }
}
