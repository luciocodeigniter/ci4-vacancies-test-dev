<?php

namespace App\Controllers\API\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel as CandidateModel;
use App\Entities\User as Candidate;

class Candidates extends ResourceController
{

    protected $modelName = CandidateModel::class;
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $response = [
            'status'        => 200,
            'message'       => 'Listing candidates',
            'candidates'    => $this->model->asArray()->getCandidates()
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
        $candidate = $this->model->asObject()->getCandidate($id);

        if (is_null($candidate)) {

            return $this->failNotFound("We didn't find the candidate {$id}");
        }

        $response = [
            'status'        => 200,
            'message'       => "Showing candidate $candidate->name",
            'candidate'     => $candidate
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
        if (empty($this->request->getPost())) {

            $response = [
                'status'        => 400,
                'message'       => "No data was send",
            ];

            return $this->fail($response);
        }

        $candidate = new Candidate($this->request->getPost());

        $this->model->setValidationRule('is_active', 'required|in_list[0,1]');

        if (!$this->model->protect(false)->save($candidate)) {

            return $this->failValidationErrors($this->model->errors());
        }

        $response = [
            'status'        => 201,
            'message'       => "Candidate created sucessful!",
        ];

        return $this->respondCreated($response);
    }


    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $candidate = $this->model->getCandidate($id);

        if (is_null($candidate)) {

            return $this->failNotFound("We didn't find the candidate {$id}");
        }

        unset($candidate->applications);

        $candidate->fill($this->request->getRawInput());

        if (!$candidate->hasChanged()) {

            $response = [
                'status'        => 200,
                'message'       => "There is no data to update",
            ];

            return $this->respond($response);
        }

        if (!$this->model->protect(false)->save($candidate)) {

            return $this->failValidationErrors($this->model->errors());
        }

        $response = [
            'status'        => 200,
            'message'       => "Candidate updated sucessful!",
        ];

        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $candidate = $this->model->asObject()->getCandidate($id);

        if (is_null($candidate)) {

            return $this->failNotFound("We didn't find the candidate {$id}");
        }

        $this->model->delete($candidate->id);

        $response = [
            'status'        => 200,
            'message'       => "Candidate deleted sucessful!",
        ];

        return $this->respondDeleted($response);
    }
}
