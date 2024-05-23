<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffAttendence;
use Illuminate\Database\Seeder;

class StaffAttendenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staffs = Staff::factory()->count(5)->create();

        foreach ($staffs as $staff) {
            for ($i = 1; $i <= 5; $i++) {
                StaffAttendence::factory()->create([
                    'staff_id' => $staff->id,
                    'add_at' => now()->format('Y-m-d')
                ]);
            }
        }

    }
}
