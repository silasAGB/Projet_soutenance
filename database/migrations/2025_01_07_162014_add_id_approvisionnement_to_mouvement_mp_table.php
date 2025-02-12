<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdApprovisionnementToMouvementMpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('mouvement_mp', function (Blueprint $table) {
        $table->unsignedBigInteger('id_approvisionnement')->nullable();
        $table->foreign('id_approvisionnement')->references('id_approvisionnement')->on('approvisionnements')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('mouvement_mp', function (Blueprint $table) {
        $table->dropForeign(['id_approvisionnement']);
        $table->dropColumn('id_approvisionnement');
    });
}

}
