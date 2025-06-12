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
            $table->string('client_email');
            $table->string('client_city')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_index')->nullable();
            $table->text('client_comment')->nullable();
            $table->text('client_token')->nullable();
            $table->string('client_social_url');
            $table->enum('client_social_type', ['telegram', 'vk', 'whatsapp']);

            // Способы доставки и оплаты
            $table->enum('delivery_method', ['pickup', 'russian_post', 'cdek'])->default('pickup');
            $table->enum('payment_method', ['cash', 'online', 'manual'])->default('cash');

            // Статус заказа
            $table->enum('status', [
//                'waiting',
                'awaiting_payment', // Заказ подтверждён, но не оплачен
                'processing',     // Оплачен, готовится
                'ready_for_pickup',
                'shipped',
                'delivered',
                'cancelled',
            ]);

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
