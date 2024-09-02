<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovisionnementsTable extends Migration
{
    public function up()
    {
        Schema::create('approvisionnements', function (Blueprint $table) {
            $table->id('id_approvisionnement');
            $table->date('date_approvisionnement');
            $table->string('reference_approvisionnement');
            $table->string('statut');
            $table->decimal('montant', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('approvisionnements');
    }
}

