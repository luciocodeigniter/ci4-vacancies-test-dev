<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use App\Entities\User;
use CodeIgniter\CLI\CLI; // para a barra de progresso


class CandidateSeeder extends Seeder
{
    public function run()
    {
        try {

            $this->db->transStart();

            $createHowManyCandidates = 100;

            $totalSteps = $createHowManyCandidates;
            $currStep   = 1;

            $userModel = Factories::models(UserModel::class);

            for ($i = 0; $i < $createHowManyCandidates; $i++) {

                if (!$userModel->skipValidation(true)->protect(false)->save(self::cadidate())) {

                    dd($userModel->errors());
                }

                if (service('request')->isCLI()) {

                    CLI::showProgress($currStep++, $totalSteps);
                }
            }

            $this->db->transComplete();

            echo "{$createHowManyCandidates} cadidatos criados com sucesso!" . PHP_EOL;
        } catch (\Exception $e) {

            echo $e->getMessage();
        }
    }

    public static function cadidate()
    {
        $faker = \Faker\Factory::create();

        $candidate = new User([
            'name'              => $faker->unique()->name(),
            'email'             => $faker->unique()->email(),
            'is_active'         => 1,
            'password'          => '123456',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);

        return $candidate;
    }
}
