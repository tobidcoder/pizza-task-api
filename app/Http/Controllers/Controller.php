<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($data, $response_message, $response_code='')
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'response_message' => $response_message,
            'response_code'    => $response_code,
        ];


        return response()->json($response, 200);
    }


    public function sendError($error, $errorMessages = [], $response_code='', $code = 404)
    {
        $response = [
            'success' => false,
            'response_error' => $error,
            'response_code' => $response_code
        ];


        if(!empty($errorMessages)){
            $response['response_message'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

}
