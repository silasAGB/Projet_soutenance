<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFournisseurMatTable extends Migration
{
    public function up()
    {
        Schema::create('fournisseur_mat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_fournisseur');
            $table->unsignedBigInteger('id_MP');
            $table->decimal('prix_achat', 8, 2);
            $table->timestamps();

            $table->foreign('id_fournisseur')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->foreign('id_MP')->references('id')->on('matiere_premieres')->onDelete('cascade');

            $table->unique(['id_fournisseur', 'id_MP']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('fournisseur_mat');
    }
}

