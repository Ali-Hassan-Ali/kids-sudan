<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;

class VolunteeringFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => ['ar' => fake()->name(), 'en' => fake()->name()],
            'job'         => ['ar' => fake()->name(), 'en' => fake()->name()],
            'date'        => now(),
            'index'       => fake()->randomDigitNotNull(),
            'status'      => fake()->boolean(),
            'admin_id'    => Admin::first()?->id,
        ];

    }//end of run

}//end of class