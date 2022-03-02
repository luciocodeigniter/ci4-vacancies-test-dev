<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\VacancyModel;
use CodeIgniter\Config\Factories;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title'                     => 'Home',
            'totalVacancies'            => Factories::models(VacancyModel::class)->countAllResults(),
            'totalPausedVacancies'      => Factories::models(VacancyModel::class)->where('is_paused', true)->countAllResults(),
            'totalCandidates'           => count(Factories::models(UserModel::class)->getCandidates()),
            'totalLockedCandidates'     => count(Factories::models(UserModel::class)->where('is_active', false)->getCandidates()),
        ];

        return view('Home/index', $data);
    }
}
