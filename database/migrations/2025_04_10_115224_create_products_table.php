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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->json('photos');
            $table->foreignId('category_id')->constrained(
                table: 'categories', indexName: 'id'
            );
            $table->unsignedInteger('actual_price');
            $table->unsignedInteger('old_price')->nullable();
            $table->json('equipment')->nullable();
            $table->json('external_links')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('views')->default(0);

//            $table->boolean('isNew')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
