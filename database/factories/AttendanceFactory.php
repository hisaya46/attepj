<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'start_time' => $this->faker->dateTimeBetween('08:00:00', '12:00:00')->format('H:i:s'),
            'end_time' => $this->faker->dateTimeBetween('12:00:00', '20:00:00')->format('H:i:s'),
        ];
    }
}
