<?php

namespace App\Controllers\API\V1;

use App\Models\VacancyModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\RESTful\ResourceController;

class Vacancies extends ResourceController
{

    protected $modelName = VacancyModel::class;
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $response = [
            'status'      => 200,
            'message'   => 'Listing vacancies',
            'vacancies' => $this->model->asArray()->findAll()
        ];

        return $this->respond($response);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $vacancy = $this->model->asObject()->find($id);

        if (is_null($vacancy)) {

            return $this->failNotFound("Vacancy {$id} not found");
        }

        $response = [
            'status'        => 200,
            'message'       => "Show vacancy $vacancy->title",
            'vacancy'       => $vacancy
        ];

        return $this->respond($response);
    }


    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }



    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $vacancy = $this->model->find($id);

        if (is_null($vacancy)) {

            return $this->failNotFound("Vacancy {$id} not found");
        }


        $vacancy->fill($this->request->getRawInput());

        if (!$vacancy->hasChanged()) {

            $response = [
                'status'        => 200,
                'message'       => "There is no data to update",
            ];

            return $this->respond($response);
        }

        if (!$this->model->save($vacancy)) {

            return $this->failValidationErrors($this->model->errors());
        }

        $response = [
            'status'        => 200,
            'message'       => "Vacancy updated sucessful!",
        ];

        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }


    private static function rules(int $id = null)
    {
        return [
            'title' => "required|min_length[2]|max_length[120]|is_unique[vacancies.title,id,{$id}]",
            'type' => 'in_list[fr,clt,pj]',
            'description' => 'required|max_length[500]',
        ];
    }

    private static function messages()
    {
        return [
            'title'        => [
                'is_unique' => 'Essa vaga já existe. Por favor escolha outra.',
            ],
        ];
    }
}
