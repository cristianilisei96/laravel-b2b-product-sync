<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('external_id')->unique();
            $table->string('sku')->unique();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand')->nullable();

            $table->text('description')->nullable();

            $table->decimal('supplier_price', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);

            $table->unsignedInteger('stock')->default(0);
            $table->string('stock_status')->default('in_stock');

            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamp('last_synced_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
