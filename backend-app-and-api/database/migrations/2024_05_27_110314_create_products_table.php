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
            $table->foreignId('category_id')->constrained()
                ->onDelete('cascade');
            $table->string('name');
            $table->foreignId('brand_id')->constrained()
                ->onDelete('cascade');
            $table->text('product_code')->nullable();
            $table->string('slug');
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('featured_image');
            $table->enum('status', ['active', 'inactive'])
                ->default('inactive');
            $table->integer('size')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_top')->default(false);
            $table->integer('discount')->default(0);
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
