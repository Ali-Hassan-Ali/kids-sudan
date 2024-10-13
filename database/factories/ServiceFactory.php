<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Admin\WebsitsServiceImageType;
use App\Models\Admin;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'             => ['ar' => fake()->name(), 'en' => fake()->name()],
            'icon_type'         => fake()->randomElement(array_keys(WebsitsServiceImageType::array())),
            'icon'              => fake()->randomElement(['fa-solid fa-code', 'fa-solid fa-pen', 'fa-solid fa-bolt']),
            'short_description' => ['ar' => fake()->text(), 'en' => fake()->text()],
            'index'             => fake()->randomDigitNotNull(),
            'status'            => fake()->boolean(),
            'admin_id'          => Admin::factory(),
        ];

    }//end of run

}//end of class