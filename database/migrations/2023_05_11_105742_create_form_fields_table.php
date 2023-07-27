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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->uniqid();
            $table->string('label_name');
            $table->string('input_name');
            $table->text('label_description')->nullable();
            $table->enum('field_type', ['date','text', 'number', 'radio','checkbox','password','button','color'.'date','datetime-local','email','file','hidden','image','month','range','reset','search','submit','tel','time','url','week','MultiLineText','multiCheckBox','dropdownSelect','textarea']);
            $table->text('validation_rules')->nullable();
            $table->text('field_values')->nullable();
            $table->string('table_name')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->unique(['label_name', 'object_id', 'group_id']);
            $table->unsignedBigInteger('object_id');
            $table->foreign('object_id')->references('id')->on('form_object_types')->onDelete('cascade');
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('form_object_type_groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
