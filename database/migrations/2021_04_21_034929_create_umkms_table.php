<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmkmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('region_id');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->string('address');
            $table->decimal('latitude',12,8)->nullable();
            $table->decimal('longitude',12,8)->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('background')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('umkms');
    }
}
