<?php

namespace Database\Seeders;

use App\Constants\PermissionConstant;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        Permission::firstOrCreate(['name'=> 'view users']);
        Permission::firstOrCreate(['name'=> 'create users']);
        Permission::firstOrCreate(['name'=> 'edit users']);
        Permission::firstOrCreate(['name'=> 'remove users']);

        // course
        Permission::firstOrCreate(['name'=> PermissionConstant::VIEW_COURSE]);
        Permission::firstOrCreate(['name'=> PermissionConstant::CREATE_COURSE]);
        Permission::firstOrCreate(['name'=> PermissionConstant::EDIT_COURSE]);
        Permission::firstOrCreate(['name'=> PermissionConstant::REMOVE_COURSE]);

        // student
        Permission::firstOrCreate(['name'=> PermissionConstant::VIEW_STUDENT]);
        Permission::firstOrCreate(['name'=> PermissionConstant::CREATE_STUDENT]);
        Permission::firstOrCreate(['name'=> PermissionConstant::EDIT_STUDENT]);
        Permission::firstOrCreate(['name'=> PermissionConstant::REMOVE_STUDENT]);
    }
}
