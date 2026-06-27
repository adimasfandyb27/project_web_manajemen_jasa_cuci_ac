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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_order')->unique();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('technicians')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->date('tanggal_order');
            $table->dateTime('jadwal_servis')->nullable();

            $table->text('alamat_servis');
            $table->text('keluhan')->nullable();

            $table->enum('status', [
                'pending',
                'dijadwalkan',
                'proses',
                'selesai',
                'dibatalkan',
            ])->default('pending');

            $table->decimal('subtotal_jasa', 15, 2)->default(0);
            $table->decimal('subtotal_sparepart', 15, 2)->default(0);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);

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
        Schema::dropIfExists('service_orders');
    }
};
