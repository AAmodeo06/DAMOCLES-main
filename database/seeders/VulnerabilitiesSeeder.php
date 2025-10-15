<?php

// REALIZZATO DA: Cosimo Mandrillo

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vulnerability;

class VulnerabilitiesSeeder extends Seeder
{
    public function run()
    {
        // Vulnerabilità principali - Cosimo Mandrillo
        $vulnerabilities = [
            [
                'name' => 'Phishing',
                'description' => 'Attacco che cerca di ottenere informazioni sensibili tramite email fraudolente'
            ],
            [
                'name' => 'Smishing',
                'description' => 'Variante del phishing che utilizza SMS per ingannare le vittime'
            ],
            [
                'name' => 'Vishing',
                'description' => 'Phishing vocale che utilizza telefonate per ottenere informazioni'
            ],
            [
                'name' => 'Spear Phishing',
                'description' => 'Attacco phishing mirato a specifici individui o organizzazioni'
            ],
            [
                'name' => 'Business Email Compromise',
                'description' => 'Compromissione delle email aziendali per frodi finanziarie'
            ],
            [
                'name' => 'Social Engineering',
                'description' => 'Manipolazione psicologica per ottenere informazioni o accessi'
            ],
        ];

        foreach ($vulnerabilities as $vuln) {
            Vulnerability::create($vuln);
        }
    }
}
