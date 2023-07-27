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
        Schema::create('form_object_type_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('machine_name');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('form_object_type_id');
            $table->foreign('form_object_type_id')->references('id')->on('form_object_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_object_type_groups');
    }
};
