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

        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number');
            $table->decimal('delivery_charge')->default('0');
            $table->string('payment_method')->default('cash_on_delivery');
            $table->enum('payment_status', [
                'pending',
                'completed',
                'cancelled',
            ])->default('pending');
            $table->string('shipping_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
