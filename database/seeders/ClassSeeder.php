<?php

namespace Database\Seeders;

use App\Models\_Class;
use Illuminate\Database\Seeder;
use Database\Factories\SectionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $sections = SectionFactory::new()->count(2)->create();

        foreach ($sections as $section) {
            for ($i = 1; $i <= 2; $i++){
                _Class::create([
                    'section_id' => $section->id,
                    'name' => 'CLASS '.$i. '-'.$section->id
                ]);
            }
        }
    }
}
