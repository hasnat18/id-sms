<?php

namespace Database\Factories;

use App\Models\_Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionsFactory extends Factory
{
    protected $model = _Session::class;

    public function definition()
    {
        return [
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => true,
        ];
    }
}
