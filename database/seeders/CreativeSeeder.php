<?php

namespace Database\Seeders;

use App\Models\Creative;
use Illuminate\Database\Seeder;

class CreativeSeeder extends Seeder
{
    public function run()
    {
        Creative::factory(10)->create();

    }//end of run

}//end of class