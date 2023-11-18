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
        Schema::table('order_table', function (Blueprint $table) {
            $table->dropColumn([
                'reservation_name',
            ]);
            $table->dateTime('reserved_from')
                ->default(Carbon\Carbon::now())
                ->change();
            $table->dateTime('reserved_to')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_table', function (Blueprint $table) {
            //
        });
    }
};
