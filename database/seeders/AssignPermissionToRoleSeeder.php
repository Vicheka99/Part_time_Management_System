<?php

namespace Database\Seeders;

use App\Constants\PermissionConstant;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Contracts\Permission;

class AssignPermissionToRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // role admin
        $admin = Role::where('name', 'admin')->first();
        $employee = Role::where('name', 'employee')->first();
        if ($admin) {
            $admin->syncPermissions([
                // user management
                'view users',
                'create users',
                'edit users',
                'remove users',
                // courses
                PermissionConstant::VIEW_COURSE,
                PermissionConstant::CREATE_COURSE,
                PermissionConstant::EDIT_COURSE,
                PermissionConstant::REMOVE_COURSE,
                // students
                PermissionConstant::VIEW_STUDENT,
                PermissionConstant::CREATE_STUDENT,
                PermissionConstant::EDIT_STUDENT,
                PermissionConstant::REMOVE_STUDENT,
            ]);
        }

        if ($employee) {
            // Teachers can manage students and view courses
            $employee->syncPermissions([
                PermissionConstant::VIEW_COURSE,
                PermissionConstant::VIEW_STUDENT,
                PermissionConstant::CREATE_STUDENT,
                PermissionConstant::EDIT_STUDENT,
                PermissionConstant::REMOVE_STUDENT,
            ]);
        }

    }
}
