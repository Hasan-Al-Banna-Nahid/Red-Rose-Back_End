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
        Schema::create('model_test_alls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('class_id');
            $table->string('name');
            $table->string('subject');
            $table->string('type');
            $table->timestamps();
            $table
                ->foreign('class_id')
                ->references('id')
                ->on('all_classes')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_tests');
    }
};
