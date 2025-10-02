<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhishingContextsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phishing_contexts')->insert([
            ['description' => 'Banking/Financial', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Online Accounts', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Online shopping', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Technical support', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Work/Career', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Competitions/Awards', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Personal safety', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Healthcare', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
