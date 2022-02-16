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

    public function edit(int $id = null)
    {
        $vacancy = $this->vacancyModel->find($id);

        if (is_null($vacancy)) {

            return redirect()->route('vacancies')->with('danger', "Vaga {$id} não encontrada");
        }

        $data = [
            'title'     => "Editando a vaga $vacancy->title",
            'vacancy'   => $vacancy
        ];

        return view('Vacancies/edit', $data);
    }

    public function update(int $id = null)
    {
        $vacancy = $this->vacancyModel->find($id);

        if (is_null($vacancy)) {

            return redirect()->route('vacancies')->with('danger', "Vaga {$id} não encontrada");
        }

        $vacancy->fill($this->removeSpoofingFromRequest());

        if (!$vacancy->hasChanged()) {

            return redirect()->back()->with('info', "Não há dados para atualizar");
        }

        if (!$this->vacancyModel->save($vacancy)) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->vacancyModel->errors())
                ->withInput();
        }

        return redirect()->route('vacancies.show', [$vacancy->id])->with('success', "Dados salvos com sucesso!");
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
