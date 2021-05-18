<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained();
            $table->unsignedInteger('favorited_id');
            $table->string('favorited_type', 50);
            $table->timestamps();

            $table->unique(['user_id', 'favorited_id', 'favorited_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
