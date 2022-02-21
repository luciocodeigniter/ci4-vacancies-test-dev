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

        $type = match ($this->attributes['type']) {
            'pj'        => 'Contrato - Pessoa Jurídica',
            'clt'       => 'CLT - Pessoa Física',
            'fr'        => 'Contrato - Freelancer',
            default     => 'Tipo desconhecido'
        };

        return $type;
    }

    public function isPaused()
    {
        return $this->is_paused ? 'Pausada para candidaturas' : 'Liberada para candidaturas';
    }
}
