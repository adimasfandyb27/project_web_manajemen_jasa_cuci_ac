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
        Schema::table('service_order_details', function (Blueprint $table) {
            $table->foreignId('customer_ac_unit_id')
                ->after('service_order_id')
                ->constrained('customer_ac_units')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_order_details', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_ac_unit_id');
        });
    }
};
