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
        Schema::create('my_products_subtitles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_subtitle_id');
            $table->string('sub_title');
            $table->longText('description');
            $table->string('icon')->nullable();
            $table->foreign('my_subtitle_id')->references('id')->on('my_product_specifications')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_products_subtitles');
    }
};
