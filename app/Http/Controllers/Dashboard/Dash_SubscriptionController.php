<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ChangeStatusSubsciptionRequest;
use App\Http\Resources\common\SubscriptionResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Subscription;
use App\Services\Dashboard\Dash_SubscripationServices;
use Illuminate\Http\Request;

class Dash_SubscriptionController extends Controller
{
    //
use ApiResponseTrait;
    public function __construct(protected Dash_SubscripationServices $dash_subscraption_services)
    {
        $this->dash_subscraption_services=$dash_subscraption_services;

    }
    //get all subscripation in dashboard
     public function get_subscraptions()
     {
        $result=$this->dash_subscraption_services->get_subscraptions();
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            // $paginated = $this->paginate($result_data['subscraptions']);
            $output['subscraptions'] = SubscriptionResource::collection($result_data['subscraptions']);
            // $output['meta'] = $paginated['meta'];
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
    
     }
     //change status subscripte
      
     public function change_status_subscripte(ChangeStatusSubsciptionRequest $request, Subscription $subscription)
     {
        $input_data=$request->validated();
        $result=$this->dash_subscraption_services->change_status_subscripte($input_data,$subscription);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['subscription'] = new SubscriptionResource($result_data['subscription']);
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
       
     }

     public function delete_subscripte( Subscription $subscription)
     {
         $result=$this->dash_subscraption_services->delete_subscripte($subscription);
         $output=[];
         if ($result['status_code'] == 200) {
             $result_data = $result['data'];
             $output=$result_data;
         }
 
         return $this->send_response($output, $result['msg'], $result['status_code']);
           
     }
}

