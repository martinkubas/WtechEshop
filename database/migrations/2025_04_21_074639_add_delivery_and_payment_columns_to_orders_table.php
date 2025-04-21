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
            $table->string('payment_method')->nullable()->after('order_status');
            $table->string('delivery_method')->nullable()->after('payment_method');
            $table->text('delivery_address')->nullable()->after('delivery_method');
            $table->string('delivery_status')->nullable()->after('delivery_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'delivery_method',
                'delivery_address',
                'delivery_status',
            ]);
        });
    }
};
