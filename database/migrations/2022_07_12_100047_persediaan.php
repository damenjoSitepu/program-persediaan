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
        Schema::create('persediaan', function (Blueprint $table) {
            $table->id('persediaan_id');
            $table->date('tanggal_transaksi');
            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('user_login_id')->on('user_login');
            $table->bigInteger('picker_gudang_id')->unsigned();
            $table->foreign('picker_gudang_id')->references('user_login_id')->on('user_login');
            $table->integer('status');
            $table->integer('is_confirm')->default(0);
            $table->integer('is_confirm_by_admin')->default(0);
            $table->integer('is_delete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persediaan');
    }
};
