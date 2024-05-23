<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'dob' => $this->faker->date(),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'joining_date' => $this->faker->date(),
            'salary' => $this->faker->randomFloat(2, 30000, 80000),
            'extra_note' => null,
            'is_bus_incharge' => false,
            'transport_id' => null,
            'added_by' => 1,
            'id_proof' => null,
            'status' => true,
            'user_id' => function () {
                return User::factory()->create()->id;
            }
        ];
    }
}


