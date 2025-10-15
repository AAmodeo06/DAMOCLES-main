<?php
<<<<<<< Updated upstream
// Realizzato da: Cosimo Mandrillo
=======

// REALIZZATO DA: Cosimo Mandrillo
>>>>>>> Stashed changes

namespace Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< Updated upstream
use App\Models\AttackType;
=======
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
>>>>>>> Stashed changes

class AttackTypesSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< Updated upstream
        $attackTypes = [
            ['name' => 'Phishing', 'description' => 'Email fraudolente'],
            ['name' => 'Password Management', 'description' => 'Gestione credenziali'],
            ['name' => 'Social Engineering', 'description' => 'Manipolazione psicologica'],
            ['name' => 'Ransomware', 'description' => 'Prevenzione ransomware'],
            ['name' => 'Mobile Security', 'description' => 'Sicurezza dispositivi mobili']
        ];

        foreach ($attackTypes as $type) {
            AttackType::create($type);
=======
       $items = [
            'Phishing', 'Smishing', 'Vishing', 'Spear Phishing',
            'Business Email Compromise', 'Social Engineering',
        ];

        foreach ($items as $name) {
            DB::table('attack_types')->updateOrInsert(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
>>>>>>> Stashed changes
        }
    }
}
