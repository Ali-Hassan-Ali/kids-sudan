<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            PermissionsDemoSeeder::class,
            RoleSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            CreativeSeeder::class,
            SkillsSeeder::class,
            ToolsSeeder::class,
            ClientSeeder::class,
            FaqSeeder::class,
            VolunteeringSeeder::class,
            ServiceSeeder::class,
        ]);

    }//end of run

}//en dof class