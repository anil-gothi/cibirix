<?php

namespace App\Services;

class ResponseService
{
    public function success($response)
    {
        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }
    public function errors($response)
    {
        return response()->json($response, 400, [], JSON_NUMERIC_CHECK);
    }
}

?>