<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApplicationModel;
use App\Models\VacancyModel;
use CodeIgniter\Config\Factories;
use Exception;

class Jobs extends BaseController
{

    public function __construct()
    {
        $this->vacancyModel = Factories::models(VacancyModel::class);
        $this->applicationModel = Factories::models(ApplicationModel::class);

        $this->user = service('auth')->user();
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
        $vacancy = $this->vacancyModel->find($id);

        if (is_null($vacancy)) {

            return redirect()->back()->with('danger', "Não encontramos a vaga {$id}");
        }

        if ($this->applicationModel->candidateHasThisJob($vacancy->id)) {

            return redirect()->back()->with('info', "Você já se candidatou para essa vaga");
        }

        $application = [
            'user_id'       => $this->user->id,
            'vacancy_id'    => $vacancy->id,
        ];

        if (!$this->applicationModel->insert($application)) {

            throw new Exception("{$this->user->name}, não foi possivel processar a sua candidatura");
        }

        return redirect()->back()->with('success', "Candidatura realizada com sucesso!");
    }

    public function givUp(int $id = null)
    {
        $vacancy = $this->vacancyModel->find($id);

        if (is_null($vacancy)) {

            return redirect()->back()->with('danger', "Não encontramos a vaga {$id}");
        }

        if (!$this->applicationModel->candidateHasThisJob($vacancy->id)) {

            return redirect()->back()->with('info', "Você ainda não se candidatou para essa vaga");
        }

        if (!$this->applicationModel->destroyCandidateApplication($vacancy->id)) {

            throw new Exception("{$this->user->name}, não foi possivel processar a desistência da candidatura");
        }

        return redirect()->back()->with('success', "Desistência realizada com sucesso!");
    }

    public function myJobs()
    {

        helper('jobs');

        $data = [
            'title' => 'Minhas candidaturas',
            'jobs'  => $this->applicationModel->applications()
        ];

        return view('Jobs/my_jobs', $data);
    }
}
