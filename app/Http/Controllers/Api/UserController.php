<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function __construct(UserService $userService,ResponseService $responseService)
    {
        $this->userService = $userService;
        $this->responseService = $responseService;
    }
    // USER LISTINGS
    function userListings(Request $request)
    {
        $authUser = auth()->user();
        $request->userId = $authUser->id;
        try 
        {
            $response = $this->userService->userListings($request);  // CALL USER SERVICE
            if($response['status'])
                return $this->responseService->success($response);
            else
            return $this->responseService->errors($response);
        } catch (\Exception $e) {
            return $this->responseService->errors(['status' => false,'response' => '','msg' => $e->getMessage()]);
        }
    }
}
