<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;
use App\Enums\Admin\WebsitsSkillsImageType;

class SkillsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => ['ar' => fake()->name(), 'en' => fake()->name()],
            'icon_type'   => fake()->randomElement(array_keys(WebsitsSkillsImageType::array())),
            'icon'        => fake()->randomElement(['fa-solid fa-code', 'fa-solid fa-pen', 'fa-solid fa-bolt']),
            'description' => ['ar' => fake()->text(), 'en' => fake()->text()],
            'index'       => fake()->randomDigitNotNull(),
            'status'      => fake()->boolean(),
            'admin_id'    => Admin::first()?->id,
        ];

    }//end of run

}//end of class