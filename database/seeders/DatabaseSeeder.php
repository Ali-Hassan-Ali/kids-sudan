<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ]);

    }//end of run

}//en dof class