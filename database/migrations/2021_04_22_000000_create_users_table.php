<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('bumdes_id')->nullable();
            $table->unsignedBigInteger('umkm_id')->nullable();
            $table->string('region_id');
            $table->string('address');
            $table->decimal('latitude',12,8)->nullable();
            $table->decimal('longitude',12,8)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('email_verifed')->nullable();
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('bumdes_id')->references('id')->on('bumdeses');
            $table->foreign('umkm_id')->references('id')->on('umkms');
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
