
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->string('job_title');
            $table->string('company')->nullable();
            $table->string('start_date')->nullable();  
            $table->string('end_date')->nullable();    
            $table->text('description')->nullable();   
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employment_histories');
    }
};