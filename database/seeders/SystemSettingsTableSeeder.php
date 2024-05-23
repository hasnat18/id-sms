<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('system_settings')->insert([
            [
                'key' => 'site_title',
                'value' => env('APP_NAME', 'School Management System'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_tagline',
                'value' => env('APP_TAGLINE', ''),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


