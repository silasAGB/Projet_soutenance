<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatierePremieresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matiere_premieres', function (Blueprint $table) {
            $table->id('id_MP');
            $table->string('nom_MP');
            $table->decimal('prix_achat', 8, 2);
            $table->string('unite');
            $table->integer('qte_stock');
            $table->integer('stock_min');
            $table->string('emplacement')->nullable();
            $table->unsignedBigInteger('id_categorie');
            $table->timestamps();

            $table->foreign('id_categorie')
                  ->references('id_categorie')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matiere_premieres');
    }
}
