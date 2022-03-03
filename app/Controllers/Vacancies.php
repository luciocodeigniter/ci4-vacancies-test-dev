<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Vacancy;
use App\Models\VacancyModel;
use CodeIgniter\Config\Factories;

class Vacancies extends BaseController
{

    public function __construct()
    {
        $this->vacancyModel = Factories::models(VacancyModel::class);
    }

    public function index()
    {

        $data = [
            'title' => 'Listando as Vagas',
            'vacancies' => $this->vacancyModel->findAll(),
        ];

        return view('Vacancies/index', $data);
    }

    public function new()
    {
        $vacancy = new Vacancy(['is_paused' => false]);

        $data = [
            'title'     => "Criando nova vaga",
            'vacancy'   => $vacancy
        ];

        return view('Vacancies/new', $data);
    }

    public function create()
    {
        $vacancy = new Vacancy($this->request->getPost());

        if (!$this->vacancyModel->save($vacancy)) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->vacancyModel->errors())
                ->withInput();
        }

        return redirect()->route('vacancies.show', [$this->vacancyModel->insertID()])->with('success', "Dados salvos com sucesso!");
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


    public function deleteAllSelected()
    {
        if (!$this->request->isAJAX()) {

            return redirect()->back();
        }

        $idsToDelete = $this->request->getPost('id');

        if (is_array($idsToDelete) && !empty($idsToDelete)) {

            $this->vacancyModel->whereIn('id', $idsToDelete)->delete();
        }

        session()->setFlashdata('success', 'Registros excluídos com sucesso!');

        return $this->response->setJSON([]);
    }
}
