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
        Schema::create('photo_archives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable(); // 1940s-1990s, Festivals, Market scenes, etc.
            $table->string('decade')->nullable(); // 1940s, 1950s, etc.
            $table->unsignedBigInteger('media_id')->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('set null');
            $table->boolean('is_featured')->default(false);
            $table->date('date_taken')->nullable();
            $table->string('location')->nullable();
            $table->string('photographer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_archives');
    }
};
