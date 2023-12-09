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
        Schema::table('item_variation_order', function (Blueprint $table) {
            $table->dropForeign([
                'cashier_id',
            ]);
            $table->dropColumn([
                'cashier_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_variation_order', function (Blueprint $table) {
            //
        });
    }
};
