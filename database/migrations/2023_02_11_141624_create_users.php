<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') == false)
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string("login");
                $table->string("password");
                $table->timestamps();
            });
        if (Schema::hasTable('hash_auth_private_key') == false)
            Schema::create('hash_auth_private_key', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('id_users')->unsigned()->index()->nullable();
                $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
                $table->string('hash_login')->nullable();
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('spisok');
        Schema::dropIfExists('hash_auth_private_key');
        Schema::dropIfExists('users');
    }
}
