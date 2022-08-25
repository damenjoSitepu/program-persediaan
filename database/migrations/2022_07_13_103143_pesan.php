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
        Schema::create('pesan', function (Blueprint $table) {
            $table->id('pesan_id');
            $table->date('tanggal_pesan');
            $table->bigInteger('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('supplier_id')->on('supplier');
            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('user_login_id')->on('user_login');
            $table->bigInteger('persediaan_id')->unsigned();
            $table->foreign('persediaan_id')->references('persediaan_id')->on('persediaan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesan');
    }
};
