<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'      => 'Arabic',
                'dir'       => 'RTL',
                'code'      => 'ar',
                'default'   => 1,
                'status'    => 1,
                'index'     => 1,
                'created_at'=> now(),
                'admin_id'  => Admin::first()?->id,
            ],
            [
                'name'      => 'English',
                'dir'       => 'LTR',
                'code'      => 'en',
                'default'   => 0,
                'status'    => 1,
                'index'     => 2,
                'created_at'=> now(),
                'admin_id'  => Admin::first()?->id,
            ],

        ];

        \App\Models\Language::insert($data);

    }//end of run
    
}//end of class