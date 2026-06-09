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
        if (Schema::hasTable(User::TABLE_NAME)) {

            Schema::table(User::TABLE_NAME, function (Blueprint $table) {
                if(Schema::hasColumn(User::TABLE_NAME, 'name')){
                    $table->dropColumn('name');
                }
                $table->string(User::FIRST_NAME);
                $table->string(User::LAST_NAME);
                $table->string(User::GENDER);
                $table->string(User::PROFILE);
                $table->string(User::CREATED_BY);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
