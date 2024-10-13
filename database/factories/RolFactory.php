<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;
// use App\Models\Role;

class RolFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name'       => faker()->unique()->name(),
            'guard_name' => fake()->randomElement(['admin', 'web'])
            'admin_id'   => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }//end of run

}//end of class