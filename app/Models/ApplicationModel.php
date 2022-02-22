<?php

namespace App\Models;


use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table            = 'applications';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'user_id', 'vacancy_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';



    public function applications(int $candidateID = null)
    {
        $userID = $candidateID ?? service('auth')->user()->id;

        return $this
            ->join('vacancies', 'vacancies.id = applications.vacancy_id')
            ->where('applications.user_id', $userID)
            ->orderBy('applications.created_at', 'DESC')
            ->findAll();
    }
}
