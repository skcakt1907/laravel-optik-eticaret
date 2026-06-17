<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sira')->default(0);
            $table->boolean('durum')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('brand')->nullable();          // marka
            $table->string('cover')->nullable();          // kapak görseli
            $table->json('images')->nullable();           // galeri
            $table->text('short_desc')->nullable();       // özet
            $table->longText('description')->nullable();  // açıklama
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable(); // indirimli
            $table->unsignedInteger('stock')->default(0);
            $table->json('attributes')->nullable();       // çerçeve tipi, renk, cinsiyet, materyal...
            $table->boolean('featured')->default(false);  // öne çıkan
            $table->unsignedInteger('sira')->default(0);
            $table->boolean('durum')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('city')->nullable();     // il
            $table->string('district')->nullable(); // ilçe
            $table->text('address');
            $table->text('note')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('payment_method')->default('havale'); // havale | iyzico | kapida
            $table->string('payment_status')->default('pending'); // pending | paid | failed
            $table->string('status')->default('yeni'); // yeni | hazirlaniyor | kargoda | teslim | iptal
            $table->json('payment_meta')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('anahtar')->unique();
            $table->text('deger')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('settings');
    }
};
