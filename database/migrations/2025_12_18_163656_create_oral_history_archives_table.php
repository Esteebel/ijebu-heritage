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
        Schema::create('oral_history_archives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('story');
            $table->string('category'); // Folktales, War stories, Childhood memories, Myths, Personal experiences
            $table->unsignedBigInteger('audio_file_id')->nullable();
            $table->foreign('audio_file_id')->references('id')->on('media')->onDelete('set null');
            $table->unsignedBigInteger('featured_media_id')->nullable();
            $table->foreign('featured_media_id')->references('id')->on('media')->onDelete('set null');
            $table->boolean('is_featured')->default(false);
            $table->string('storyteller')->nullable();
            $table->date('recorded_date')->nullable();
            $table->string('location')->nullable();
            $table->text('transcript')->nullable();
            $table->text('cultural_context')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oral_history_archives');
    }
};
