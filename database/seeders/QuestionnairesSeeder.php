<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnairesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questionnaires')->insert([
            [
                'name' => 'HAIS',
            ],
            [
                'name' => 'DAMOCLES',
            ]
        ]);
    }
}
