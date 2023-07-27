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
        // Schema::table('my_product_youtubelinks', function (Blueprint $table) {
        //     //
        // });
        if (Schema::hasTable('my_product_youtubelinks')) {
            Schema::table('my_product_youtubelinks', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false)->after('product_id');;
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('my_product_youtubelinks', function (Blueprint $table) {
            //
        });
    }
};
