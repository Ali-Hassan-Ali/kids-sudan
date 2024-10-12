<?php

namespace Database\Seeders;

use App\Models\Tools;
use Illuminate\Database\Seeder;

class ToolsSeeder extends Seeder
{
    public function run()
    {
        Tools::factory(10)->create();

    }//end of run

}//end of class