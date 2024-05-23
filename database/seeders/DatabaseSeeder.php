<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleAndPermissionTableSeeder::class);
        $this->call(SystemSettingsTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        // $this->call(StaffAttendenceSeeder::class);
        $this->call(ClassSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(SubjectSeeder::class);
    }
}
