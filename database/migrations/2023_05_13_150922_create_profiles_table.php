<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('date');
            $table->string('once');
            $table->string('points');
            $table->string('bio')->nullable();
            $table->string('designation')->nullable();
            $table->string('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->longText('about')->nullable();
            $table->string('phone')->nullable();
            $table->string('class_id')->nullable();
            $table->string('institute')->nullable();
            $table->string('address')->nullable();
            $table->string('upazila_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('division_id')->nullable();
            $table->string('country_id')->nullable();
            $table->string('company_name')->nullable();
            $table->timestamps();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
