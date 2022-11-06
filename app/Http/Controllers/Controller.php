<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendResponse($data, $message)
    {
        return response()->json([
            "data" => $data,
            "status" => true,
            "message" => $message
        ]);
    }

    protected function sendError($data, $message, $status = 200)
    {
        return response('', $status)->json([
            "data" => $data,
            "status" => false,
            "message" => $message
        ]);
    }
}
