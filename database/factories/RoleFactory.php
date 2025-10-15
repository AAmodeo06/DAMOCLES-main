<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            // Il test crea 'Impiegato', ma avere una default non guasta
            'name' => $this->faker->randomElement(['Impiegato','Valutatore','Amministratore']),
        ];
    }
}
