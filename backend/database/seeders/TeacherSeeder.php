<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'employee']);

        $names = [
            ['James', 'Wilson', 'Male'],
            ['Sarah', 'Mitchell', 'Female'],
            ['Robert', 'Kim', 'Male'],
            ['Linda', 'Torres', 'Female'],
            ['Carlos', 'Rivera', 'Male'],
            ['Angela', 'Park', 'Female'],
            ['Daniel', 'Chen', 'Male'],
            ['Emily', 'Davis', 'Female'],
            ['Michael', 'Brown', 'Male'],
            ['Sophia', 'Martinez', 'Female'],
        ];

        $teachers = collect($names)->map(function (array $teacher, int $index) {
            [$firstName, $lastName, $gender] = $teacher;
            $number = $index + 1;

            $user = User::updateOrCreate(
                [User::EMAIL => "teacher{$number}@example.com"],
                [
                    User::FIRST_NAME => $firstName,
                    User::LAST_NAME => $lastName,
                    User::GENDER => $gender,
                    User::PROFILE => '',
                    User::USERNAME => "teacher{$number}",
                    User::PASSWORD => 'Teacher@12345',
                    User::CREATED_BY => '0',
                ],
            );

            $user->syncRoles(['employee']);

            return $user;
        });

        Course::orderBy(Course::ID)->get()->each(function (Course $course, int $index) use ($teachers) {
            $course->update([Course::USER_ID => $teachers[$index % $teachers->count()]->id]);
        });
    }
}
