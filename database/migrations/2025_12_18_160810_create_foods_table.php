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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('recipe')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('preparation_method')->nullable();
            $table->text('cultural_significance')->nullable();
            $table->unsignedBigInteger('featured_media_id')->nullable();
            $table->string('region')->nullable();
            $table->timestamps();

            $table->foreign('featured_media_id')->references('id')->on('media')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
