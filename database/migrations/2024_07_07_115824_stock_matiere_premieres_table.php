<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StockMatierePremieresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matiere_premieres', function (Blueprint $table) {
            $table->integer('stock_min')->default(10)->after('qte_stock');
            $table->string('emplacement')->nullable()->after('stock_min');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matiere_premieres', function (Blueprint $table) {
            $table->dropColumn('stock_min');
            $table->dropColumn('emplacement');
        });
    }
}
