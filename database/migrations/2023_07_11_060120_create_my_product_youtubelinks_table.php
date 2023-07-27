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
        Schema::create('my_product_youtubelinks', function (Blueprint $table) {
            $table->id();
            $table->string('youtubelink');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('my_products')->onDelete('cascade');
           // $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_product_youtubelinks');
    }
};
