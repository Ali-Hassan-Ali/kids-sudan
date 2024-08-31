<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // User::factory(30)
        //     ->has(
        //         Trip::factory(rand(1,20)),
        //     )->create();

        User::factory(100)->create();

    }//end of run

}//end of class