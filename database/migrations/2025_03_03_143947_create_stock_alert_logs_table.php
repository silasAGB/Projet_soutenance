<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockAlertLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_alert_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mp');
            $table->decimal('qte_stock', 10, 2);
            $table->decimal('stock_min', 10, 2);
            $table->string('status'); // 'sent', 'failed'
            $table->text('error')->nullable();
            $table->timestamps();

            $table->foreign('id_mp')->references('id_MP')->on('matieres_premieres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_alert_logs');
    }
}
