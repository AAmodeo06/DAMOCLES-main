<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhishingEmotionalTriggersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phishing_emotional_triggers')->insert([
            ['description' => 'Fear', 'tooltip' => 'Fear can make you act impulsively.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Anger', 'tooltip' => 'Anger can cloud your judgment.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Sadness', 'tooltip' => 'Sadness might make you vulnerable.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Joy', 'tooltip' => 'Joy can lead to overconfidence.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Disgust/Contempt', 'tooltip' => 'Disgust or contempt can make you dismissive.', 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Surprise', 'tooltip' => 'Surprise can make you easily swayed.', 'created_at' => now(), 'updated_at' => now()],
        ]);        
    }
}
