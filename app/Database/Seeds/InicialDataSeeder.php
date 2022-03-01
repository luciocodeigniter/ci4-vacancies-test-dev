<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InicialDataSeeder extends Seeder
{
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(CandidateSeeder::class);
        $this->call(VacancySeeder::class);
    }
}
