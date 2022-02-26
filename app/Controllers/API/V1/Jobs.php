<?php

namespace App\Controllers\API\V1;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Factories;

use App\Controllers\BaseController;
use App\Models\VacancyModel;

class Jobs extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->vacancyModel = Factories::models(VacancyModel::class);
    }

    public function index()
    {
        $vacancies = $this->vacancyModel->where('is_paused', false)->asArray()->findAll();

        $response = [
            'status' => 200
        ];

        if (empty($vacancies)) {

            $response['message'] = 'There is no jobs at the moment';

            return $this->respond($response);
        }

        $response['message'] = 'Know our vacancies';
        $response['vacancies'] = $vacancies;

        return $this->respond($response);
    }
}
