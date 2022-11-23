<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    function __construct(AuthService $authService, ResponseService $responseService)
    {
        $this->authService = $authService;
        $this->responseService = $responseService;
    }
    // USER SIGNUP DETAILS
    public function signup(Request $request)
    {
        $rules['name'] = 'required|max:50';
        $rules['email'] = 'required|email|unique:users|max:50';
        $rules['password'] = 'required|min:6|max:50';

        $msg['name.required'] = 'Name is required';
        $msg['email.required'] = 'Email is required';
        $msg['email.email'] = 'Invalid Email';
        $msg['password.required'] = 'Password is required';
        $msg['password.min'] = 'Password must be at least 6 characters long';
        
        $validator = Validator::make($request->all(), $rules,$msg);
        if ($validator->fails())
           return $this->responseService->errors(['status' => false,'response' => '','msg' => $validator->messages()->first()]);
        try 
        {
            $response = $this->authService->signup($request);  // CALL AUTH SERVICE
            return $this->responseService->success($response);
        } catch (\Exception $e) {
            return $this->responseService->errors(['status' => false,'response' => '','msg' => $e->getMessage()]);
        }
    }
    // USER LOGIN 
    public function login(Request $request)
    {
        $rules['email'] = 'required|email|max:50';
        $rules['password'] = 'required|min:6|max:50';

        $msg['name.required'] = 'Name is required';
        $msg['email.required'] = 'Email is required';
        $msg['email.email'] = 'Invalid Email';
        $msg['password.required'] = 'Password is required';
        $msg['password.min'] = 'Password must be at least 6 characters long';
        
        $validator = Validator::make($request->all(), $rules,$msg);
        if ($validator->fails())
        return $this->responseService->errors(['status' => false,'response' => '','msg' => $validator->messages()->first()]);
        
        try 
        {
            $response = $this->authService->login($request);  // CALL AUTH SERVICE
            if($response['status'])
                return $this->responseService->success($response);
            else
                return $this->responseService->errors($response);
        } catch (\Exception $e) {
            return $this->responseService->errors($e->getMessage());
        }
        
    }
}
