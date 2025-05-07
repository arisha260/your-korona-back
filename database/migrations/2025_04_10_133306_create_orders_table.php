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

            // Клиентская информация
            $table->string('client_name');
            $table->string('client_tel');
            $table->string('client_email')->nullable();
            $table->string('client_city')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_index')->nullable();
            $table->text('client_comment')->nullable();
            $table->text('client_token')->nullable();

            // Способы доставки и оплаты
            $table->enum('delivery_method', ['pickup', 'russian_post', 'sdek', 'courier'])->default('pickup');
            $table->enum('payment_method', ['cash', 'sbp', 'card'])->default('on_site');

            // Статус заказа
            $table->enum('status', ['waiting', 'processing', 'shipped', 'delivered', 'cancelled'])->default('waiting');

            // Финансовая информация
            $table->unsignedInteger('total_quantity');
            $table->unsignedInteger('subtotal_price');
            $table->unsignedInteger('total_price');

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
