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
        Schema::create('kings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('regnal_name')->nullable();
            $table->integer('birth_year')->nullable();
            $table->integer('death_year')->nullable();
            $table->date('reign_start_date')->nullable();
            $table->date('reign_end_date')->nullable();
            $table->unsignedBigInteger('dynasty_id')->nullable();
            $table->text('short_bio')->nullable();
            $table->text('full_bio')->nullable();
            $table->unsignedBigInteger('portrait_media_id')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();

            $table->foreign('dynasty_id')->references('id')->on('dynasties')->onDelete('set null');
            $table->foreign('portrait_media_id')->references('id')->on('media')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kings');
    }
};
