<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Magazine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Magazine\CreateMagazineRequest;
use App\Http\Requests\Magazine\UpdateMagazineRequest;
use App\Http\Resources\Common\MagazineResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use App\Services\Magazine\MagazineServices;

class Dash_MagazineController extends Controller
{
    //

    use ApiResponseTrait;
    public function __construct(protected MagazineServices $magazine_services)
    {
     $this->magazine_services=$magazine_services;

    }

    //get all  magazines in dashboard by admin 

    public function get_magazines()
    {
        
        $result=$this->magazine_services->get_magazines();
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['magazines'] =  MagazineResource::collection($result_data['magazines']);
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
         

    }
    //add magazine if admin or publisher

    public function create_magazine(CreateMagazineRequest $request)
    {
        $input_data=$request->validated();
        $result=$this->magazine_services->create_magazine($input_data);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['magazine'] = new MagazineResource($result_data['magazine']);
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
          
    }
    //update
    public function update_magazine(UpdateMagazineRequest $request,Magazine $magazine)
    {
        $input_data=$request->validated();
        $result=$this->magazine_services->update_magazine($input_data,$magazine);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['magazine'] = new MagazineResource($result_data['magazine']);
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
          
    }
    //delete 
    public function delete_magazine( Magazine $magazine)
    {
        $result=$this->magazine_services->delete_magazine($magazine);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output=$result_data;
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
          
    }
   

}
