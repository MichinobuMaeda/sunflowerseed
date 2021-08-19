<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vote_set_id')->constrained();
            $table->string('user_id');
            $table->string('user_name');
            $table->timestamps();
            $table->unique(['vote_set_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_histories');
    }
}
