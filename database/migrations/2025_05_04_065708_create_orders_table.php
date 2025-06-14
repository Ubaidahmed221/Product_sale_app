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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('billing_address');
            $table->json('shipping_address')->nullable();

            $table->string('payment_method');
            $table->string('payment_status')->default('pending');
            $table->string('status')->default('pending');
            $table->string('currency')->comment('PKR Or USD Currency');
            $table->decimal('subtotal',10,2);
            $table->decimal('shipping_amount',10,2)->nullable();
            $table->decimal('total',10,2);
            $table->string('transaction_id')->nullable();
            $table->string('stripe_session_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
