<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Vacancy extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];

    protected $casts   = [
        'is_paused'   => 'boolean',
    ];

    public function type()
    {
        return $this->attributes['type'] === 'pj' ? 'Pessoa Jurídica' : ($this->attributes['type'] === 'pf' ? 'Pessoa Físca' : 'Freelancer');
    }

    public function isPaused()
    {
        return $this->is_paused ? 'Pausada para candidaturas' : 'Liberada para candidaturas';
    }
}
