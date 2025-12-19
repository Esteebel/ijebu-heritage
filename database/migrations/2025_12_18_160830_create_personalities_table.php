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
        Schema::create('personalities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('biography')->nullable();
            $table->text('achievements')->nullable();
            $table->string('category')->nullable(); // politician, business, entertainment
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
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
        Schema::dropIfExists('personalities');
    }
};
