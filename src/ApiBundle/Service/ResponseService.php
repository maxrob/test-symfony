<?php

namespace ApiBundle\Service;

use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Service ConvertService
 * @package ApiBundle\Service
 */
class ResponseService
{

    public function success($data)
    {
        return new JsonResponse([ "data" => $data ], 200);
    }

    public function error($message, $status = 500)
    {
        return new JsonResponse([ "message" => $message ], $status);
    }
}