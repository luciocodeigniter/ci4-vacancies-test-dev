<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Vacancy extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];

    protected $casts   = [
        'is_paused'   => 'boolean',
    ];


    public function setType(string $type)
    {
        $this->attributes['type'] = strtolower($type);

        return $this;
    }

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
        return $this->is_paused ? '<span class="text-danger">Pausada para candidaturas</span>' : '<span class="text-primary">Liberada para candidaturas</span>';
    }
}
