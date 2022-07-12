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
        Schema::create('timelines', function (Blueprint $table) {
            $table->foreignId('userId')->constrained('users')->onDelete('cascade')->comment('ユーザId');
            $table->foreignId('tweetId')->constrained('tweets')->onDelete('cascade')->comment('ツイートId');
            $table->string('state')->nullable()->default('0')->comment('状態');
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
        Schema::dropIfExists('timelines');
    }
};
