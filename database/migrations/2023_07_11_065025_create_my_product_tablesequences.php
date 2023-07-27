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
        Schema::create('my_product_tablesequences', function (Blueprint $table) {
            $table->id();
            $table->string('myproduct_table');
            $table->string('table');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
        Schema::create('myproduct_sequneceorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sequence_id');
           
            $table->foreign('sequence_id')->references('id')->on('my_product_tablesequences')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_product_tablesequences');
    }
};
