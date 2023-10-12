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
        Schema::create('tracks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('readable');
            $table->string('title');
            $table->string('title_short');
            $table->string('title_version');
            $table->string('link');
            $table->integer('duration');
            $table->integer('rank');
            $table->boolean('explicit_lyrics');
            $table->string('preview');
            $table->foreignUuid('artist_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('album_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
