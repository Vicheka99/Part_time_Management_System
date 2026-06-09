<?php

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(Course::TABLE_NAME, function (Blueprint $table) {
            $table->unsignedBigInteger(Course::USER_ID)->after(Course::END_DATE);
            $table->foreign(Course::USER_ID)->references(User::ID)->on(User::TABLE_NAME)->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course', function (Blueprint $table) {
            //
        });
    }
};
