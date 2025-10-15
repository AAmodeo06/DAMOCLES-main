<?php
// Realizzato da: Luigi La Gioia

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;

class UsersDemoSeeder extends Seeder
{
    public function run(): void
    {
        $evaluatorRole = Role::where('name', 'Evaluator')->first();
        $impiegatoRole = Role::where('name', 'Impiegato')->first();
        $responsabileRole = Role::where('name', 'Responsabile Non IT')->first();
        $dirigenteRole = Role::where('name', 'Dirigente')->first();

        $acmeOrg = Organization::where('name', 'Acme Corporation')->first();

        User::create([
            'name' => 'Valutatore Demo',
            'email' => 'evaluator@example.com',
            'password' => Hash::make('password'),
            'role_id' => $evaluatorRole->id,
            'organization_id' => $acmeOrg->id
        ]);

        $users = [
            ['name' => 'Mario Rossi', 'email' => 'mario.rossi@example.com', 'role_id' => $impiegatoRole->id],
            ['name' => 'Laura Bianchi', 'email' => 'laura.bianchi@example.com', 'role_id' => $responsabileRole->id],
            ['name' => 'Giuseppe Verdi', 'email' => 'giuseppe.verdi@example.com', 'role_id' => $dirigenteRole->id],
            ['name' => 'Anna Neri', 'email' => 'anna.neri@example.com', 'role_id' => $impiegatoRole->id]
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'role_id' => $userData['role_id'],
                'organization_id' => $acmeOrg->id
            ]);
        }
    }
}
