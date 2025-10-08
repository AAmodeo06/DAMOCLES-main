<?php
// Realizzato da: Cosimo Mandrillo

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Organization;

class RolesAndOrgsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Impiegato'],
            ['name' => 'Responsabile Non IT'],
            ['name' => 'Responsabile IT'],
            ['name' => 'Dirigente'],
            ['name' => 'Evaluator']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $organizations = [
            ['name' => 'Acme Corporation'],
            ['name' => 'Tech Startup SRL'],
            ['name' => 'Pubblica Amministrazione'],
            ['name' => 'Università di Roma']
        ];

        foreach ($organizations as $org) {
            Organization::create($org);
        }
    }
}
