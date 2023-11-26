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
        Schema::create('jobs', function (Blueprint $table) {
            $table->uuid('job_id')->primary();
            $table->string('job_code');
            $table->string('title');
            $table->string('location');
            $table->string('job_type');
            $table->string('salary')->nullable();
            $table->date('application_deadline')->nullable();
            $table->string('description');
            $table->string('requirements');
            $table->boolean('accepting_applications');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
