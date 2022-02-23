<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VacancyModel;
use CodeIgniter\Config\Factories;

class Jobs extends BaseController
{

    public function __construct()
    {
        $this->vacancyModel = Factories::models(VacancyModel::class);
    }

    public function index()
    {
        $data = [
            'title' => 'Conheça as nossas vagas',
            'jobs'  => $this->vacancyModel->getAllForApplications()
        ];

        return view('Jobs/index', $data);
    }
}
