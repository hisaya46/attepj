<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Rest;

use Illuminate\Database\Eloquent\Factories\Factory;

class RestFactory extends Factory
{
    protected $model = Rest::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attendance_id' => Attendance::factory(),
            'breakin_time' => $this->faker->dateTimeBetween('11:00:00', '12:00:00')->format('H:i:s'),
            'breakout_time' => $this->faker->dateTimeBetween('12:00:00', '13:00:00')->format('H:i:s'),
        ];
    }
}
