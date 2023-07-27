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
        // Schema::table('myproduct_sequneceorders', function (Blueprint $table) {
        //     //
        // });
        if (Schema::hasTable('myproduct_sequneceorders')) {
            Schema::table('myproduct_sequneceorders', function (Blueprint $table) {
                $table->string('order_id')->after('sequence_id');;
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('myproduct_sequneceorders', function (Blueprint $table) {
            //
        });
    }
};
