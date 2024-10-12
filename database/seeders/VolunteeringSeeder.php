<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Volunteering;

class VolunteeringSeeder extends Seeder
{
    public function run()
    {
        Volunteering::factory(10)->create();

    }//end of run

}//end of class