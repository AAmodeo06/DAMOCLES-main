<?php

namespace Database\Seeders;

use App\Models\User;
use Egulias\EmailValidator\EmailParser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(PhishingContextsSeeder::class);
        $this->call(PhishingPersuasionsSeeder::class);
        $this->call(PhishingEmotionalTriggersSeeder::class);
        $this->call(LLMsSeeder::class);
        $this->call(QuestionnairesSeeder::class);
        $this->call(VulnerabilitiesSeeder::class);
        $this->call(AttackTypesSeeder::class);
        $this->call(HumanFactorsSeeder::class);
        $this->call(HumanFactorVulnerabilitySeeder::class);
    }
}
