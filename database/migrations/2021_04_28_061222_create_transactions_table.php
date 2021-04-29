<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('umkm_id');
            $table->unsignedBigInteger('bumdes_id');
            $table->string('invoice_number');
            $table->string('address');
            $table->double('total_price');
            $table->integer('discount')->nullable();
            $table->string('voucher')->nullable();
            $table->string('noted')->nullable();
            $table->string('status')->default('order');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('umkm_id')->references('id')->on('umkms');
            $table->foreign('bumdes_id')->references('id')->on('bumdeses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
