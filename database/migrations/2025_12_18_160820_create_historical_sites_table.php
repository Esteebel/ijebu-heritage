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
        Schema::create('historical_sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('location')->nullable();
            $table->string('coordinates')->nullable();
            $table->text('historical_significance')->nullable();
            $table->unsignedBigInteger('featured_media_id')->nullable();
            $table->string('preservation_status')->nullable();
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
        Schema::dropIfExists('historical_sites');
    }
};
