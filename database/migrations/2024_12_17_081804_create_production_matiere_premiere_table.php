<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionMatierePremiereTable extends Migration
{
    public function up()
    {
        Schema::create('production_matiere_premiere', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->unsignedBigInteger('id_production'); // Clé étrangère vers production
            $table->unsignedBigInteger('id_MP'); // Clé étrangère vers matière première
            $table->integer('qte'); // Quantité utilisée pour la production

            $table->timestamps();

            // Définir les relations
            $table->foreign('id_production')
                ->references('id_production')
                ->on('productions')
                ->onDelete('cascade');

            $table->foreign('id_MP')
                ->references('id_MP')
                ->on('matiere_premieres')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('production_matiere_premiere');
    }
}
