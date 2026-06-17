<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->unsignedInteger('sira')->default(0);
            $table->boolean('durum')->default(true);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->date('tarih')->nullable();
            $table->boolean('durum')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('comment');
            $table->unsignedTinyInteger('stars')->default(5);
            $table->string('photo')->nullable();
            $table->boolean('durum')->default(true);
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('yeni');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('appointments');
    }
};
