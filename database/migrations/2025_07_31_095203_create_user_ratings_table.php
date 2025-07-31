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
        Schema::create('user_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('imdb_id', 20); // IMDb ID (z.B. tt0133093)
            $table->string('movie_title'); // Film-Titel für bessere UX
            $table->integer('rating')->unsigned(); // 1-5 Sterne
            $table->text('review')->nullable(); // Optionaler Bewertungstext
            $table->timestamps();
            
            // Ein User kann einen Film nur einmal bewerten
            $table->unique(['user_id', 'imdb_id']);
            
            // Index für schnelle Abfragen
            $table->index('imdb_id');
            $table->index(['imdb_id', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_ratings');
    }
};
