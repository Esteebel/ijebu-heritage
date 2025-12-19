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
        Schema::create('diaspora_stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('storyteller')->nullable();
            $table->string('origin_location')->nullable();
            $table->string('destination')->nullable();
            $table->text('immigration_story')->nullable();
            $table->text('achievements')->nullable();
            $table->unsignedBigInteger('featured_media_id')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();

            $table->foreign('featured_media_id')->references('id')->on('media')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diaspora_stories');
    }
};
