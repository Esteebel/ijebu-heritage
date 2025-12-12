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
        Schema::create('king_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('king_id');
            $table->unsignedBigInteger('media_id');
            $table->timestamps();

            $table->foreign('king_id')->references('id')->on('kings')->onDelete('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');

            $table->unique(['king_id', 'media_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('king_media');
    }
};
