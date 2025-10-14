<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->date('dob')->nullable();
            $table->string('gender', 10)->nullable();
            $table->text('summary')->nullable();
            $table->text('hobbies')->nullable();
            $table->text('interests')->nullable();
            $table->string('template', 50)->default('template1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
