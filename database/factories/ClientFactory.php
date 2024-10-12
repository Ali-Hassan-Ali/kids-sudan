<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;
use App\Enums\Admin\WebsitsSkillsImageType;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => ['ar' => fake()->name(), 'en' => fake()->name()],
            'job'         => ['ar' => fake()->name(), 'en' => fake()->name()],
            'description' => ['ar' => fake()->text(), 'en' => fake()->text()],
            'index'       => fake()->randomDigitNotNull(),
            'status'      => fake()->boolean(),
            'admin_id'    => Admin::first()?->id,
        ];

    }//end of run

}//end of class