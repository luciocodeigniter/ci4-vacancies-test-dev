<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;

class Candidates extends BaseController
{
    public function __construct()
    {
        $this->userModel = Factories::models(UserModel::class);
    }

    public function index()
    {
        $request = (object) $this->request->getGet();

        $data = [
            'title'         => 'Listando os candidatos',
            'candidates'    => $this->userModel->getCandidates($request),
            'pager'         => $this->userModel->pager,
        ];

        return view('Candidates/index', $data);
    }
}
