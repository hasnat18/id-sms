<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Fees;
use App\Models\User;
use App\Models\_Class;
use App\Models\Student;
use App\Models\_Session;
use App\Models\Admission;
use App\Models\FeeDetails;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
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

        $classes = _Class::pluck('id')->toArray();

        $session = _Session::create([
            'start_date' => Carbon::now()->addDays(7),
            'end_date' => Carbon::now()->addMonths(12),
            'status' => true
        ]);

        $fee_types = ['admission', 'tuition', 'transportation'];
        $trans = $faker->randomNumber(5, true);
        $total = $faker->randomNumber(5, true) + $faker->randomNumber(5, true) + $faker->randomNumber(5, true);

        $amount = 0;

        for ($i=1; $i<=10; $i++){
            $admission = Admission::create([
                "student_name" => $faker->name,
                "gender" => $gender[array_rand($gender)],
                "dob" => '2004-09-01',
                "religion" => 'Islam',
                "cast" => 'abc',
                "blood_group" => 'A+',
                "address" => 'address 2554',
                "state" => 'sindh',
                "city" => 'Karachi',
                "country" => 'Pakistan',
                "phone" => '03125748961',
                "email" => $faker->unique()->safeEmail,
                "extra_note" => 'nothing',
                "gr_no" => 'GR-00'.$i,
                "father_name" => $faker->name,
                "father_phone" => '011454686754',
                "father_occ" => 'nothing',
                "mother_name" => $faker->name,
                "mother_phone" => '0121546746465',
                "mother_occ" => 'nothing',
                "student_pic" => 'non',
                "is_trans" => 0,
                "transport_id" => 0,
                "__class_id" => $classes[array_rand($classes)],
                "__session_id" => $session->id,
                "user_id" => 1,
                "status" => 'admitted'
            ]);

            $student = Student::create([
                'admission_id' => $admission->id,
                '__class_id' => $admission->__class_id,
                '__session_id' => $session->id,
                'roll_no' => '00'.$i,
                'name' => $admission->student_name,
            ]);

            //create fee
        

            $fee = Fees::create([
                'admission_id' => $admission->id,
                '__session_id' => $session->id,
                'student_id' => $student->id,
                'month_of' => Carbon::now()->format('M-Y'),
                'due_date' => Carbon::now()->addDays(10),
                'total' => $total,
            ]);
            
            foreach ($fee_types as $type){
                if ($type == 'admission') {
                    $amount = $faker->randomNumber(5, true);
                }
                if ($type == 'tuition') {
                    $amount = $faker->randomNumber(5, true);
                }
                if ($type == 'transportation') {
                    $faker->randomNumber(5, true);
                }
                if ($amount > 0){
                    FeeDetails::create([
                        'fee_id' => $fee->id,
                        'fee_type' => $type,
                        'fee_amount' => $amount,
                    ]);
                }
            }

            $user = User::create([
                'name' => $admission->student_name,
                'email' => $admission->email,
                'password' => Hash::make('student123'),
            ]);
            
            $role = Role::find(3);
            $user->assignRole([$role->id]);
            Admission::where('id', $admission->id)->update([ 'student_auth_id' => $user->id ]);
            Fees::where('admission_id', $admission->id)->update([ 'user_id' => $user->id ]);
        }
    }
}
