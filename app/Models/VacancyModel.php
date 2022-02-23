<?php

namespace App\Models;

use App\Entities\Vacancy;
use CodeIgniter\Model;

class VacancyModel extends Model
{

    protected $table            = 'vacancies';
    protected $returnType       = Vacancy::class;
    protected $allowedFields    = [
        'title', 'type', 'is_paused', 'description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[2]|max_length[120]|is_unique[vacancies.title,id,{id}]',
        'type' => 'in_list[fr,clt,pj]',
        'description' => 'required|max_length[500]',
    ];

    protected $validationMessages = [
        'title'        => [
            'is_unique' => 'Essa vaga já existe. Por favor escolha outra.',
        ],
        'type'        => [
            'in_list' => 'O tipo da vaga deve ser: Freelancer ou Pessoa Física ou Pessoa Jurídica',
        ],
    ];


    public function getAll(object $request)
    {

        if (!isset($request->order)) {

            return $this->paginate(20);
        }

        $vacancies = match ($request->order) {

            'id' => $this->orderBy('id', 'DESC')->paginate(20),
            'title' => $this->orderBy('title', 'ASC')->paginate(20),
            'type' => $this->orderBy('type', 'ASC')->paginate(20),
            'is_paused' => $this->orderBy('is_paused', 'ASC')->paginate(20),
            'description' => $this->orderBy('description', 'ASC')->paginate(20),
            default => throw new \Exception('Unsupported'),
        };


        return $vacancies;
    }


    public function getAllForApplications()
    {

        $tableFields = [
            'applications.user_id',
            'applications.vacancy_id',
            'vacancies.*'
        ];

        return $this
            ->select($tableFields)
            ->join('applications', 'applications.vacancy_id = vacancies.id', 'LEFT')
            ->where('is_paused', false)
            ->findAll();
    }
}
