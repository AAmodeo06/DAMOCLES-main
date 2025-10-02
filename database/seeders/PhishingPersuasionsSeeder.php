<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhishingPersuasionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phishing_persuasions')->insert([
            ['description' => 'Authority', 'tooltip' => 'Persuading by demonstrating authority or expertise in a subject matter.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Commitment', 'tooltip' => 'Encouraging commitment or consistency through small initial actions or statements.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Liking', 'tooltip' => 'Using friendly or attractive characteristics to increase persuasiveness.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Reciprocation', 'tooltip' => 'Triggering the urge to reciprocate favors or concessions.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Scarcity', 'tooltip' => 'Creating urgency by highlighting limited availability or scarcity of an item or opportunity.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Social Proof', 'tooltip' => 'Influencing behavior by showing that others like us are doing the same thing.', 'created_at' => now(), 'updated_at' => now()],
        ]);        
    }
}
