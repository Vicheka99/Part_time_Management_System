<?php

use App\Models\User;
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
        if (Schema::hasTable(User::TABLE_NAME) && !Schema::hasColumn(User::TABLE_NAME, User::USERNAME)) {
            Schema::table(User::TABLE_NAME, function (Blueprint $table) {
                $table->string(User::USERNAME)->nullable()->unique()->after(User::PROFILE);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable(User::TABLE_NAME) && Schema::hasColumn(User::TABLE_NAME, User::USERNAME)) {
            Schema::table(User::TABLE_NAME, function (Blueprint $table) {
                $table->dropUnique(User::TABLE_NAME . '_' . User::USERNAME . '_unique');
                $table->dropColumn(User::USERNAME);
            });
        }
    }
};
