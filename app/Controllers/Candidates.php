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

    public function show(int $id = null)
    {
        $candidate = $this->userModel->getCandidate($id);

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
        $candidate = $this->userModel->getCandidate($id);

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
        $candidate = $this->userModel->getCandidate($id);

        $request = $this->removeSpoofingFromRequest();

        if (empty($request['password'])) {

            unset($request['password']);
            unset($request['password_confirmation']);
            $this->userModel->disablePasswordValidation();
        }


        $candidate->fill($request);

        if (!$candidate->hasChanged()) {

            return redirect()->back()->with('info', "Não há dados para atualizar");
        }

        if (!$this->userModel->protect(false)->save($candidate)) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->userModel->errors())
                ->withInput();
        }

        return redirect()->route('candidates.show', [$candidate->id])->with('success', "Dados salvos com sucesso!");
    }
}
