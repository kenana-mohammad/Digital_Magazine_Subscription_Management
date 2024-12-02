<?php

namespace App\Http\Controllers\app\Subscription;

use App\Http\Resources\app\CommentResource;
use App\Models\Magazine;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\app\Article\AddCommentRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\App\App_SubscriptionServices;
use App\Http\Requests\app\Payment\PaymentRequest;
use App\Http\Resources\app\Payment\PaymentResource;
use App\Http\Resources\common\SubscriptionResource;
use App\Http\Requests\app\Subscription\CreateSubscriptionRequest;
use App\Http\Resources\Common\Article\ArticleResource;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class AppSubscriptionController extends Controller
{
    //
    use ApiResponseTrait;

    public function __construct(protected App_SubscriptionServices $app_subscription_services )
    {
 $this->app_subscription_services=$app_subscription_services;
    }


    public function add_subscripte(CreateSubscriptionRequest $request ,Magazine $magazine)
    {

        $input_data=$request->validated();
        $result=$this->app_subscription_services->add_subscripte($input_data,$magazine);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['subscripe'] = new SubscriptionResource($result_data['subscripe']);
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
          
    }
    //get my subscripations
            public function payment(PaymentRequest $request ,Subscription $subscription)
            {
                $input_data=$request->validated();
                $result=$this->app_subscription_services->payment($input_data,$subscription);
                $output=[];
                if ($result['status_code'] == 200) {
                    $result_data = $result['data'];
                    $output['comment'] = new PaymentResource($result_data['comment']);
                }
        
                return $this->send_response($output, $result['msg'], $result['status_code']);
              
            }
            //get articles belongs magazine عرض المقالات الخاصة بالمجلات للمشتركين 
         public function get_articles(Magazine $magazine)
         {
            $result=$this->app_subscription_services->get_articles($magazine);
            $output=[];
            if ($result['status_code'] == 200) {
                $result_data = $result['data'];
                $output['article'] =  ArticleResource::collection($result_data['article']);
            }
    
            return $this->send_response($output, $result['msg'], $result['status_code']);        
        
            
         }
         //get article 
         public function get_article(Magazine $magazine,Article $article)
         {
            $result=$this->app_subscription_services->get_article($magazine,$article);
            $output=[];
            if ($result['status_code'] == 200) {
                $result_data = $result['data'];
                $output['article'] =  new ArticleResource($result_data['article']);
            }
    
            return $this->send_response($output, $result['msg'], $result['status_code']);        
         }
         //add comment 
         public function add_comment(AddCommentRequest $request,Magazine $magazine,Article $article)
         {
            $input_data=$request->validated();
            $result=$this->app_subscription_services->add_comment($input_data,$magazine,$article);
            $output=[];
            if ($result['status_code'] == 200) {
                $result_data = $result['data'];
                $output['payment'] = new CommentResource($result_data['payment']);
            }
    
            return $this->send_response($output, $result['msg'], $result['status_code']);
          
         }

}
