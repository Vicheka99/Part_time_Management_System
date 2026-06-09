<?php

use App\Models\Student;
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
        Schema::create(Student::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(Student::FIRST_NAME);
            $table->string(Student::LAST_NAME);
            $table->string(Student::GENDER);
            $table->string(Student::SCORE);
            $table->string(Student::STATUS);
            $table->unsignedBigInteger(Student::COURSE_ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
