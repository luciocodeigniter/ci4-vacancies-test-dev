<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel as CandidateModel;
use CodeIgniter\Config\Factories;
use App\Entities\User as Candidate;

class Candidates extends BaseController
{
    public function __construct()
    {
        $this->candidateModel = Factories::models(CandidateModel::class);
    }

    public function index()
    {

        $data = [
            'title'         => 'Listando os candidatos',
            'candidates'    => $this->candidateModel->getCandidates(),
        ];

        return view('Candidates/index', $data);
    }

    public function new()
    {
        $candidate = new Candidate(['is_active' => false]);

        $data = [
            'title'     => "Editando o candidato $candidate->name",
            'candidate'   => $candidate
        ];

        return view('Candidates/new', $data);
    }

    public function create()
    {
        $candidate = new Candidate($this->request->getPost());

        if (!$this->candidateModel->protect(false)->save($candidate)) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->candidateModel->errors())
                ->withInput();
        }

        return redirect()->route('candidates.show', [$this->candidateModel->getInsertID()])->with('success', "Dados salvos com sucesso!");
    }

    public function show(int $id = null)
    {
        $candidate = $this->candidateModel->getCandidate($id);

        if (is_null($candidate)) {

            return redirect()->route('candidates')->with('danger', "Candidato {$id} não encontrado");
        }

        $data = [
            'title'     => "Detalhes do candidato $candidate->name",
            'candidate'   => $candidate
        ];

        return view('Candidates/show', $data);
    }

    public function edit(int $id = null)
    {
        $candidate = $this->candidateModel->getCandidate($id);

        if (is_null($candidate)) {

            return redirect()->route('candidates')->with('danger', "Candidato {$id} não encontrado");
        }

        $data = [
            'title'     => "Editando o candidato $candidate->name",
            'candidate'   => $candidate
        ];

        return view('Candidates/edit', $data);
    }

    public function update(int $id = null)
    {
        $candidate = $this->candidateModel->getCandidate($id);

        if (is_null($candidate)) {

            return redirect()->route('candidates')->with('danger', "Candidato {$id} não encontrado");
        }

        $request = $this->removeSpoofingFromRequest();

        if (empty($request['password'])) {

            unset($request['password']);
            unset($request['password_confirmation']);
            $this->candidateModel->disablePasswordValidation();
        }


        $candidate->fill($request);

        if (!$candidate->hasChanged()) {

            return redirect()->back()->with('info', "Não há dados para atualizar");
        }

        if (!$this->candidateModel->protect(false)->save($candidate)) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->candidateModel->errors())
                ->withInput();
        }

        return redirect()->route('candidates.show', [$candidate->id])->with('success', "Dados salvos com sucesso!");
    }

    public function delete(int $id = null)
    {
        $candidate = $this->candidateModel->getCandidate($id);

        if (is_null($candidate)) {

            return redirect()->route('candidates')->with('danger', "Candidato {$id} não encontrado");
        }

        $this->candidateModel->delete($candidate->id);

        return redirect()->route('candidates')->with('success', "Candidato excluído com sucesso!");
    }


    public function deleteAllSelected()
    {
        if (!$this->request->isAJAX()) {

            return redirect()->back();
        }

        $idsToDelete = $this->request->getPost('id');

        if (is_array($idsToDelete) && !empty($idsToDelete)) {

            dd(in_array(service('auth')->user()->id, $idsToDelete));

            // We guarantee that the admin id will not be deleted
            if (!in_array(service('auth')->user()->id, $idsToDelete)) {

                $this->candidateModel->whereIn('id', $idsToDelete)->delete();
            }
        }

        session()->setFlashdata('success', 'Registros excluídos com sucesso!');

        return $this->response->setJSON([]);
    }
}
