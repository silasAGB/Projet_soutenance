<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvariesToProductionsTable extends Migration
{
    public function up()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->text('avaries')->nullable(); // Ajoutez la colonne avaries
        });
    }

    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('avaries'); // Supprimez la colonne avaries si nécessaire
        });
    }
}
