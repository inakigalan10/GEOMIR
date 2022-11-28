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
        Schema::create('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_post');
            $table->foreign('id_post')->references('id')->on('posts')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            // Eloquent does not support composite PK :-(
            // $table->primary(['column1', 'column2']);
        });
        // Eloquent compatibility workaround :-)
        Schema::table('likes', function (Blueprint $table) {
            $table->id()->first();
            $table->unique(['id_post', 'id_user']);
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
        Schema::dropIfExists('likes');
    }
};
