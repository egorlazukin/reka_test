<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpisok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spisok', function (Blueprint $table) {
            $table->id();
            $table->string("photo");
            $table->string("Text");
            $table->bigInteger('id_users')->unsigned()->index()->nullable();
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string("tags");
            $table->bigInteger('id_spisok')->unsigned()->index()->nullable();
            $table->foreign('id_spisok')->references('id')->on('spisok')->onDelete('cascade');
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
    }
}
