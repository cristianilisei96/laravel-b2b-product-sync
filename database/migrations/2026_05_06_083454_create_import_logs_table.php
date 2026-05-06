<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('import_logs', function (Blueprint $table) {
            $table->id();

            $table->string('source')->default('dummyjson');
            $table->string('status')->default('success');

            $table->unsignedInteger('products_created')->default(0);
            $table->unsignedInteger('products_updated')->default(0);
            $table->unsignedInteger('products_skipped')->default(0);

            $table->text('message')->nullable();
            $table->json('context')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_logs');
    }
};
