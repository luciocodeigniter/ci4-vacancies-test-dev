<?php

namespace App\Filters\API;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Factories;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class VerifiedFilter implements FilterInterface
{

    use ResponseTrait;


    public function __construct()
    {
        $this->response = service('response');
        $this->userModel = Factories::models(UserModel::class);
    }

    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('JWT_SECRET');
        $header = $request->getHeader("Authorization");
        $token = null;


        // extract the token from the header
        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }


        // check if token is null or empty
        if (is_null($token) || empty($token)) {

            return $this->failUnauthorized('You are not logged in');
        }

        try {


            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Can we decode?
            if (!$decoded) {

                return $this->failUnauthorized('You are not logged in');
            }

            // Get the user
            $user = $this->userModel->getByCriteria(['email' => $decoded->email]);

            // We found?
            if (is_null($user)) {

                return $this->failUnauthorized('You are not logged in');
            }

            // Alread verified?
            if (is_null($user->email_verified_at)) {

                return $this->failUnauthorized('Your account has not yet been verified');
            }
        } catch (\Exception $ex) {

            return $this->failUnauthorized('You are not logged in');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
