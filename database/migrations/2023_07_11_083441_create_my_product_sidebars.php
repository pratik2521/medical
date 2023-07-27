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
        Schema::create('my_product_sidebars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_product_id');
            $table->foreign('my_product_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->string('icon_path');
            $table->string('title');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_product_sidebars');
    }
};
