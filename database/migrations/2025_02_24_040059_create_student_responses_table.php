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
        Schema::create('student_responses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('bornplace');
            $table->date('birthdate');
            $table->foreignId('province_id');
            $table->foreignId('district_id');
            $table->foreignId('subdistrict_id');
            $table->foreignId('village_id');
            $table->string('school');
            $table->string('year_graduation');
            $table->string('achievement');
            $table->integer('rangking');
            $table->string('phone');
            $table->string('program');
            $table->string('information');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_responses');
    }
};
