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

        helper('jobs');

        $data = [
            'title' => 'Conheça as nossas vagas',
            'jobs'  => $this->vacancyModel->getAllForApplications()
        ];

        return view('Jobs/index', $data);
    }


    public function apply(int $id = null)
    {
        dd($this->request->getPost());
    }

    public function givUp(int $id = null)
    {
        dd($this->request->getPost());
    }
}
