<?php

namespace App\Controllers\API\V1;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Factories;

use App\Controllers\BaseController;
use App\Models\VacancyModel;
use App\Models\ApplicationModel;
use CodeIgniter\HTTP\RequestInterface;

class Jobs extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->vacancyModel = Factories::models(VacancyModel::class);
        $this->applicationModel = Factories::models(ApplicationModel::class);
    }

    public function index()
    {

        $vacancies = $this->vacancyModel->where('is_paused', false)->asArray()->findAll();

        $response = [
            'status' => 200
        ];

        if (empty($vacancies)) {

            $response['message'] = 'There is no jobs at the moment';

            return $this->respond($response);
        }

        $response['message'] = 'Know our vacancies';
        $response['vacancies'] = $vacancies;

        return $this->respond($response);
    }

    public function myJobs()
    {

        $user = $this->populateUserFromJWTRequest();

        $response = [
            'status' => 200
        ];

        $applications = $this->applicationModel->asArray()->applications($user->id);


        if (empty($applications)) {

            $response['message'] = "{$user->name}, you have not applied for any vacancies yet.";

            return $this->respond($response);
        }

        $response['message'] = "{$user->name}, the jobs you applied for";
        $response['applications'] = $applications;

        return $this->respond($response);
    }

    public function apply(int $id = null)
    {
        $vacancy = $this->vacancyModel->find($id);

        if (is_null($vacancy)) {

            return $this->failNotFound("We didn't find the vacancy {$id}");
        }


        $user = $this->populateUserFromJWTRequest();

        $response = [
            'status'    => 200,
        ];

        if ($this->applicationModel->candidateHasThisJob($vacancy->id, $user->id)) {

            $response['message'] = 'You have already applied for this vacancy';

            return $this->respond($response);
        }

        $application = [
            'user_id'       => $user->id,
            'vacancy_id'    => $vacancy->id,
        ];

        if (!$this->applicationModel->insert($application)) {

            return $this->failServerError("{$user->name}, unable to process your application");
        }

        $response['message'] = 'Application successfully completed!';

        return $this->respond($response);
    }


    private function populateUserFromJWTRequest()
    {
        // We can safely retrieve the user from the JWT as the api_auth filter has already taken care of the JWT validation
        $user = service('auth')->attemptValidateJWT(service('request'));

        return $user;
    }
}
