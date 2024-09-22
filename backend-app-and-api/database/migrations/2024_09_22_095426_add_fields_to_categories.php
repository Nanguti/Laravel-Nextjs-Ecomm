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

        Schema::table('categories', function (Blueprint $table) {
            $table->text('summmary');
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive'])
                ->default('inactive');
            $table->boolean('is_parent')->default(false);
            $table->foreignId('added_by')->constrained('users');
            $table->boolean('is_popular')->default(value: false);
            $table->boolean('is_brand')->default(value: false);
            $table->string('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
};
