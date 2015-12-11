<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as IlluminateResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiBaseController
 */
class ApiBaseController extends Controller
{
    /**
     * @var int Status Code.
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * Getter method to return stored status code.
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter method to set status code.
     * It is returning current object
     * for chaining purposes.
     *
     * @param mixed $statusCode
     * @return current object.
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Function to return an unauthorized response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondUnauthorizedError($message = 'Unauthorized!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * Function to return forbidden error response.
     * @param string $message
     * @return mixed
     */
    public function respondForbiddenError($message = 'Forbidden!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * Function to return a Not Found response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * Function to return an internal error response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * Function to return a service unavailable response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondServiceUnavailable($message = "Service Unavailable!")
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_SERVICE_UNAVAILABLE)->respondWithError($message);
    }

    /**
     * Function to return a generic response.
     *
     * @param       $data    Data to be used in response.
     * @param array $headers Headers to b used in response.
     * @return mixed Return the response.
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Function to return an error response.
     *
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->respond(
            [
                'error' => [
                    'message'     => $message,
                    'status_code' => $this->getStatusCode()
                ]
            ]
        );
    }

    /**
     * @param $message
     * @return mixed
     */
    protected function respondCreated($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)
                    ->respond(
                        [
                            'message' => $message
                        ]
                    );
    }

    /**
     * @param $message
     * @return mixed
     */
    protected function respondUnprocessableEntity($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
                    ->respond(
                        [
                            'message' => $message
                        ]
                    );
    }
}