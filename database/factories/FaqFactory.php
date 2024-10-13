<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;

class FaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question'   => ['ar' => fake()->sentence(rand(5,12)), 'en' => fake()->sentence(rand(5,12))],
            'answer'     => ['ar' => fake()->text(), 'en' => fake()->text()],
            'status'     => fake()->boolean(),
            'index'      => fake()->randomDigitNotNull(),
            'admin_id'   => Admin::factory(),
        ];

    }//end of run

}//end of class