<?php
// Realizzato da: Cosimo Mandrillo

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttackType;

class AttackTypesSeeder extends Seeder
{
    public function run(): void
    {
        $attackTypes = [
            ['name' => 'Phishing', 'description' => 'Email fraudolente'],
            ['name' => 'Password Management', 'description' => 'Gestione credenziali'],
            ['name' => 'Social Engineering', 'description' => 'Manipolazione psicologica'],
            ['name' => 'Ransomware', 'description' => 'Prevenzione ransomware'],
            ['name' => 'Mobile Security', 'description' => 'Sicurezza dispositivi mobili']
        ];

        foreach ($attackTypes as $type) {
            AttackType::create($type);
        }
    }
}
