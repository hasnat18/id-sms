<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\StaffAttendence;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffAttendenceFactory extends Factory
{
    protected $model = StaffAttendence::class;

    public function definition()
    {
        return [
            'staff_id' => Staff::factory(),
            'time_in' => $this->faker->time(),
            'time_out' => $this->faker->time(),
            'add_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'month_off' => $this->faker->monthName(),
            'status' => $this->faker->randomElement(['absent', 'present', 'leave', 'late']),
        ];
    }
}
