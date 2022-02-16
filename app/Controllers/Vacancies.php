<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Config\Factories;

class Vacancies extends BaseController
{

    public function __construct()
    {
        $this->vacancyModel = Factories::models('VacancyModel');
    }

    public function index()
    {
        $request = (object) $this->request->getGet();

        $data = [
            'title' => 'Listando as Vagas',
            'vacancies' => $this->vacancyModel->getAll($request),
            'pager'     => $this->vacancyModel->pager
        ];

        return view('Vacancies/index', $data);
    }


    public function show(int $id = null)
    {
        $vacancy = $this->vacancyModel->find($id);

        if (is_null($vacancy)) {

            return redirect()->route('vacancies')->with('danger', "Vaga {$id} não encontrada");
        }

        $data = [
            'title'     => "Detalhes da vaga $vacancy->title",
            'vacancy'   => $vacancy
        ];

        return view('Vacancies/show', $data);
    }


    public function delete(int $id = null)
    {
        $vacancy = $this->vacancyModel->find($id);

        if (is_null($vacancy)) {

            return redirect()->route('vacancies')->with('danger', "Vaga {$id} não encontrada");
        }

        $this->vacancyModel->delete($vacancy->id);

        return redirect()->route('vacancies')->with('success', "Vaga excluída com sucesso!");
    }
}
