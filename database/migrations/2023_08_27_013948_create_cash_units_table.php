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
        Schema::create('cash_units', function (Blueprint $table) {
            $table->id();
            $table->integer('half')
                ->default(0);
            $table->integer('one')
                ->default(0);
            $table->integer('two')
                ->default(0);
            $table->integer('five')
                ->default(0);
            $table->integer('ten')
                ->default(0);
            $table->integer('twenty')
                ->default(0);
            $table->integer('fifty')
                ->default(0);
            $table->integer('hundred')
                ->default(0);
            $table->integer('two_hundred')
                ->default(0);
            $table->foreignId('cash_register_id')
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
        Schema::dropIfExists('cash_units');
    }
};
