<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalog_items', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('title');
            $table->string('size')->nullable();
            $table->text('desc')->nullable();
            $table->text('long')->nullable();
            $table->json('features')->nullable();
            $table->json('specs')->nullable();
            $table->string('price_note')->nullable();
            $table->string('price_text')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('popular')->default(99);
            $table->string('image')->nullable();
            $table->json('location')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('title');
            $table->string('location')->nullable();
            $table->string('lt')->nullable();
            $table->string('lb')->nullable();
            $table->string('duration')->nullable();
            $table->string('badge')->nullable();
            $table->string('badge_style')->default('dark');
            $table->date('completed_at')->nullable();
            $table->unsignedInteger('popular')->default(99);
            $table->string('image')->nullable();
            $table->text('desc')->nullable();
            $table->json('highlights')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('catalog_items');
    }
};