<?php

use App\Models\Course;
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
        Schema::create(Course::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(Course::TITLE);
            $table->text(Course::DESCRIPTION);
            $table->float(Course::PRICE);
            $table->date(Course::START_DATE);
            $table->date(Course::END_DATE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
