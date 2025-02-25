<?php

use App\Models\Actor;
use App\Models\Movie;
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
        Schema::create('actor_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Movie::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Actor::class)->constrained()->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_movie');
    }
};
