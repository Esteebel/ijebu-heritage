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
        Schema::create('language_items', function (Blueprint $table) {
            $table->id();
            $table->string('word_phrase');
            $table->string('pronunciation_guide')->nullable();
            $table->text('meaning')->nullable();
            $table->text('usage_example')->nullable();
            $table->string('category')->nullable(); // word, proverb, phrase
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
        Schema::dropIfExists('language_items');
    }
};
