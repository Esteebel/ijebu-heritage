<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('oral_histories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('storyteller')->nullable();
            $table->date('recording_date')->nullable();
            $table->text('transcription')->nullable();
            $table->string('category')->nullable(); // folktale, war_story, personal
            $table->unsignedBigInteger('audio_file_id')->nullable();
            $table->unsignedBigInteger('featured_media_id')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();

            $table->foreign('audio_file_id')->references('id')->on('media')->onDelete('set null');
            $table->foreign('featured_media_id')->references('id')->on('media')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oral_histories');
    }
};
