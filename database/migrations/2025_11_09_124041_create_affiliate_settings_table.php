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
        Schema::create('affiliate_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('commission_percentage', 5, 2);
            $table->decimal('min_payout', 10, 2);
            $table->boolean('auto_credit_wallet');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_settings');
    }
};
