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
        Schema::create('olu_corners', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // Your roots, Your journey, Why you created this, Vision for Ijebu future
            $table->text('content');
            $table->unsignedBigInteger('featured_media_id')->nullable();
            $table->foreign('featured_media_id')->references('id')->on('media')->onDelete('set null');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('olu_corners');
    }
};
