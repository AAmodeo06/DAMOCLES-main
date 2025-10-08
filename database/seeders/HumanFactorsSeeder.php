<?php
// Implementato da: Andrea Amodeo
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HumanFactor;
use App\Models\Vulnerability;

class HumanFactorsSeeder extends Seeder
{
    public function run()
    {
        // Human Factors dal documento - Andrea Amodeo
        $humanFactors = [
            [
                'name' => 'Education Level',
                'description' => 'Livello di istruzione completato dall\'individuo'
            ],
            [
                'name' => 'Agreeableness',
                'description' => 'Tratto di personalità: gentilezza, cooperazione'
            ],
            [
                'name' => 'Extroversion',
                'description' => 'Tratto caratterizzato dall\'essere socievoli e assertivi'
            ],
            [
                'name' => 'Conscientiousness',
                'description' => 'Responsabilità, accuratezza e diligenza'
            ],
            [
                'name' => 'Neuroticism',
                'description' => 'Instabilità emotiva e ansia'
            ],
            [
                'name' => 'Vigilance',
                'description' => 'Attenzione e prontezza verso potenziali rischi'
            ],
            [
                'name' => 'Misperception',
                'description' => 'Credenza o opinione errata su qualcosa'
            ],
        ];

        foreach ($humanFactors as $hf) {
            HumanFactor::create($hf);
        }

        // Mapping con vulnerabilità - Andrea Amodeo
        $phishing = Vulnerability::where('name', 'Phishing')->first();
        $smishing = Vulnerability::where('name', 'Smishing')->first();

        if ($phishing) {
            $phishing->humanFactors()->attach([1, 2, 5, 6, 7]); // IDs degli HF
        }

        if ($smishing) {
            $smishing->humanFactors()->attach([1, 3, 5, 7]);
        }
    }
}
