<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persediaan_detail', function (Blueprint $table) {
            $table->bigInteger('persediaan_id')->unsigned();
            $table->foreign('persediaan_id')->references('persediaan_id')->on('persediaan');
            $table->bigInteger('barang_id')->unsigned();
            $table->foreign('barang_id')->references('barang_id')->on('barang');
            $table->double('barang_entry')->default(0);
            $table->double('sisa')->default(0);
            $table->double('recovery_sisa')->default(0);
            $table->double('is_next')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persediaan_detail');
    }
};
