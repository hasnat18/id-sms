<?php

namespace Database\Seeders;

use App\Models\_Class;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = _Class::all();
        $sub = ['Urdu', 'English', 'Maths', 'Science', 'Computer', 'Sindhi', 'Drawing'];
        foreach ($classes as $cl){
            foreach ($sub as $s){
                Subject::create([
                    '__class_id' => $cl->id, 'name' => $s
                ]);
            }
        }
    }
}
