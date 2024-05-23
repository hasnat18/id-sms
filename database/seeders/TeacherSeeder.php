<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $gender = ['male', 'female'];

        for ($i=1; $i<=10; $i++){

            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('teacher123')
            ]);
    
            $role = Role::where('name', 'teacher')->first();
            $department = Department::where('name', 'Teacher')->first();
    
            $user->assignRole($role->id);
    
            $user->department()->associate($department->id)->save();
            $staff = new Staff();
            $staff->name = $user->name;
            $staff->gender = $gender[array_rand($gender)];
            $staff->dob = $faker->date();
            $staff->address = $faker->address();
            $staff->phone = $faker->phoneNumber();
            $staff->email = $user->email;
            $staff->joining_date = $faker->date();
            $staff->salary = $faker->randomFloat(2, 30000, 80000);
            $staff->user_id = $user->id;
            $staff->added_by = 1;
            $staff->id_proof = null;
            $staff->save();
        }
    }
}
