<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Auth\AuthServices;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    use ApiResponseTrait;
    public function __construct(protected AuthServices $auth_services)
    {
        $this->auth_services=$auth_services;
    }

    public function register(RegisterRequest $request)
    { 
        $input_data=$request->validated();
        $result=$this->auth_services->register($input_data);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['user'] = new UserResource($result_data['user']);
            $output['auth_token']= $result_data['auth_token'];
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
  

    }
    //login
    public function login(LoginRequest $request)
    { 
        $input_data=$request->validated();
        $result=$this->auth_services->login($input_data);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['user'] = new UserResource($result_data['user']);
            $output['auth_token']= $result_data['auth_token'];

        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
  
    }
         //logout
         public function logout( )
         { 
             $result=$this->auth_services->logout();
             $output=[];
             if ($result['status_code'] == 200) {
                 $result_data = $result['data'];
                 $output     = $result_data;
             }
    
             return $this->send_response($output, $result['msg'], $result['status_code']);
       
         }
           
}
