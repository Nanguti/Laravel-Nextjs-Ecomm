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
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('blog_post_id')->nullable();
            $table->text('comment');
            $table->enum('status', ['active', 'inactive'])
                ->default('active');
            $table->text('replied_comment')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('SET NULL');
            $table->foreign('blog_post_id')->references('id')
                ->on('blog_posts')
                ->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
