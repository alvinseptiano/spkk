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
            $table->string('email');
            $table->string('password');
            $table->date('dob');
            $table->string('role')->default('karyawan');
            $table->string('absensi')->default('D');
            $table->string('loyalitas')->default('D');
            $table->string('kinerja')->default('D');
            $table->string('perilaku')->default('D');
            $table->string('peringatan')->default('D');
            $table->string('kebersihan')->default('D');
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
        Schema::dropIfExists('users');
    }
}
