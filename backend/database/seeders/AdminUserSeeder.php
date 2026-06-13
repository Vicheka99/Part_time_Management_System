<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Create the initial administrator account.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            [User::EMAIL => env('SEED_ADMIN_EMAIL', 'admin@example.com')],
            [
                User::FIRST_NAME => 'System',
                User::LAST_NAME => 'Administrator',
                User::GENDER => 'Male',
                User::PROFILE => '',
                User::USERNAME => env('SEED_ADMIN_USERNAME', 'admin'),
                User::PASSWORD => env('SEED_ADMIN_PASSWORD', 'Admin@12345'),
                User::CREATED_BY => '0',
            ],
        );

        $admin->syncRoles(['admin']);
    }
}
