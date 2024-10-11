<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;

class CreativeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'     => ['ar' => fake()->name(), 'en' => fake()->name()],
            'date'     => now()->toDateTimeString(),
            'status'   => fake()->boolean(),
            'links'    => json_encode(['https://kids-sudan.test', 'https://kids-sudan.test']),
            'index'    => fake()->randomDigitNotNull(),
            'admin_id' => Admin::first()?->id,
        ];

    }//end of run

}//end of class