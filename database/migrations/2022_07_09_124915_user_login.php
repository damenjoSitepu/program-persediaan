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
        Schema::create('user_login', function (Blueprint $table) {
            $table->id('user_login_id');
            $table->bigInteger('jabatan_id')->unsigned();
            $table->foreign('jabatan_id')->references('jabatan_id')->on('jabatan');
            $table->string('name', 200);
            $table->string('username', 50);
            $table->text('password');
            $table->boolean('is_delete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_login');
    }
};
