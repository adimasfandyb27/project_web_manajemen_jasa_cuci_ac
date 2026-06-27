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
        Schema::create('customer_ac_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('ac_brand_id')
                ->constrained('ac_brands')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('ac_type_id')
                ->constrained('ac_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('ac_capacity_id')
                ->constrained('ac_capacities')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('model')->nullable();

            $table->string('serial_number')->nullable();

            $table->string('lokasi')->nullable();

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_ac_units');
    }
};
