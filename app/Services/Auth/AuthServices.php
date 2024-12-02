<?php
    namespace App\Services\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Contracts\Role;

    class AuthServices
    {
        public function register(array $input_data)
        {
            $result=[];
            $data=[];
            $msg='';
            $status_code=400;
            try{
                DB::beginTransaction();
                $user=User::create([
                  'name' => $input_data['name'],
                  'email' => $input_data['email'],
                  'password' => $input_data['password'],
                  'role' => $input_data['role']??'subscriber'
                ]);
                $user->assignRole($input_data['role']??'subscriber');

                DB::commit();
                $auth_token = JWTAuth::fromUser($user);

                $data['user']=$user;
                $data['auth_token']=$auth_token;
                $status_code=200;
                $msg='تم تسجيل حساب جديد';
            }
            catch (Exception $e) {
                DB::rollBack();
                Log::debug($e);
    
                $status_code = 500;
                $data = $e;
                $msg = 'error ' . $e->getMessage();
    
            }
    
            $result = [
                'data' => $data,
                'status_code' => $status_code,
                'msg' => $msg,
            ];
    
            return $result;

        }
        //login 
        public function login(array $input_data)
        {
            $result=[];
            $data=[];
            $msg='';
            $status_code=400;
            try{
                  $credentials = [
            'email' => $input_data['email'],
            'password' => $input_data['password'],
        ];
                   if (!$auth_token = Auth::guard('api')->attempt($credentials)) {

            $status_code = 404;
            $msg = 'Please Check your email and Password';
        } else {

            $user = Auth::guard('api')->user();

            $data['user'] = $user;
            $data['auth_token']=$auth_token;
            $status_code = 200;
            $msg = 'logged In';
        }
    }
            catch (Exception $e) {
                Log::debug($e);
    
                $status_code = 500;
                $data = $e;
                $msg = 'error ' . $e->getMessage();
    
            }
    
            $result = [
                'data' => $data,
                'status_code' => $status_code,
                'msg' => $msg,
            ];
    
            return $result;
        }

        //logout
        public function logout()
    {
        $data = [];
        $status_code = 400;
        $msg = '';
        $result = [];

        if (auth('api')->user()) {
            // Mark the user's phone as not verified
            $user_id = auth(guard: 'api')->user()->id;
            $user = User::find($user_id);
            // Delete the current user's access token
            $user->tokens()->delete();
            auth('api')->logout();

            $status_code = 200;
            $msg = "تم تسجيل الخروج بنجاح!...";
        } else {
            $status_code = 400;
            $msg = 'لايمكن التحقق من المستخدم، فشل تسجيل الخروج';
        }

        $result = [
            'data' => $data,
            'status_code' => $status_code,
            'msg' => $msg,
        ];

        return $result;
    }
    }
?>