<?php

namespace App\Database\Seeds;

use CodeIgniter\Config\Factories;
use CodeIgniter\Database\Seeder;
use Exception;

class VacancySeeder extends Seeder
{
    public function run()
    {
        try {

            $this->db->transStart();

            $vacancyModel = Factories::models('VacancyModel');

            foreach (self::vacancies() as $vacancy) {

                if (!$vacancyModel->save($vacancy)) {

                    echo '<pre>';
                    print_r($vacancyModel->errors());
                    exit;
                }
            }

            $this->db->transComplete();

            echo "Vagas criadas com sucesso!" . PHP_EOL;
        } catch (\Exception $e) {

            echo $e->getMessage();
        }
    }

    private static function vacancies()
    {
        return [

            [
                'title'         => 'Desenvolvedor PHP Júnior',
                'type'          => 'pj',
                'is_paused'     => false,
                'description'   => 'Vaga para Desenvolvedor PHP Júnior 100% remoto',
            ],

            [
                'title'         => 'Desenvolvedor FrontEnd Júnior',
                'type'          => 'pf',
                'is_paused'     => true,
                'description'   => 'Vaga para Desenvolvedor FrontEnd Júnior 100% remoto',
            ],

            [
                'title'         => 'Analista de Marketing Digital',
                'type'          => 'fr',
                'is_paused'     => false,
                'description'   => 'Analista de Marketing Digital 100% remoto',
            ],

        ];
    }
}
