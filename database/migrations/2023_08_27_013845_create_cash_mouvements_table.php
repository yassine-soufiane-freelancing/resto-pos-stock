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
        Schema::create('cash_mouvements', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->string('mouvement_type');
            $table->string('mouvement_description');
            $table->string('image_url')
                ->nullable();
            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_mouvements');
    }
};
