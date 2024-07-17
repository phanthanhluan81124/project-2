<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->text('slug');
            $table->text('image');
            $table->string('short_description', 300);
            $table->text('content');
            $table->integer('view');
            $table->unsignedBigInteger('cate_parent_id');
            $table->unsignedBigInteger('cate_son_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
