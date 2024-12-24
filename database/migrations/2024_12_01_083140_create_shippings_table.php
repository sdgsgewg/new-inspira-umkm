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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('shipping_method_id')->constrained('shipping_methods')->onDelete('cascade');
            $table->enum('shipping_status', [
                'Awaiting Pickup', 'In Transit', 'Delivered'
            ])->default('Awaiting Pickup');
            $table->string('tracking_number')->nullable(); // Nomor resi
            $table->timestamp('shipping_time')->nullable();
            $table->timestamp('delivery_time')->nullable();

            // Menambah index
            $table->index('transaction_id');
            $table->index('shipping_method_id');
            $table->index('shipping_status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
