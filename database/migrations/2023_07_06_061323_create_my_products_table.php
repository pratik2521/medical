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
        Schema::create('my_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('product_modelname')->nullable();
            $table->string('product_price')->nullable();
            $table->string('product_discount')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('my_product_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_product_id');
            $table->foreign('my_product_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->string('image_name');
            $table->string('image_path');
            $table->string('image_thumbnail')->nullable();
            $table->string('image_type');
            $table->enum('type', ['main_section','slider', 'single']);
            $table->string('image_extension');
            $table->string('image_order_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('my_product_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_product_id');
            $table->foreign('my_product_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->string('icon_path');
            $table->string('title');
            $table->longText('description');
            $table->string('order_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('my_product_specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_product_id');
            $table->foreign('my_product_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->string('title');
            //$table->string('sub_title');
            //$table->longText('description');
            //$table->string('icon');
            $table->string('image_url');
            $table->enum('image_position', ['right', 'left']);
            $table->string('order_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('my_product_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_product_id');
            $table->foreign('my_product_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->string('user_name');
            $table->string('rating');
            $table->string('location');
            $table->string('review');
            $table->string('image_url');
            $table->string('order_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });


        Schema::create('my_product_faqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_product_id');
            $table->foreign('my_product_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->string('title');
            $table->longText('description');
            $table->string('order_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
        Schema::create('my_product_multi_features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('my_product_assing_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_product_id');
            $table->foreign('my_product_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->unsignedBigInteger('my_feature_id');
            $table->foreign('my_feature_id')->references('id')->on('my_product_multi_features')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('my_product_features_compares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('my_product_id');
            $table->foreign('my_product_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->unsignedBigInteger('my_product_with_id');
            $table->foreign('my_product_with_id')->references('id')->on('my_products')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_products');
    }
};
