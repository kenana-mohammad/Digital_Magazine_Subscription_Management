<?php
    namespace App\Services\App;

use App\Models\Article;
use App\Models\Comment;
use Exception;
use App\Models\Magazine;
use App\Models\Payment;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

    class App_SubscriptionServices{
        use AuthorizesRequests;

        public function add_subscripte(array $input_data,Magazine $magazine)
        {
            $result=[];
            $data=[];
            $msg='';
            $status_code=400;
            try{
                DB::beginTransaction();
               // التحقق من صلاحية الاشتراك
    $this->authorize('subscribe', $magazine);


    $existingSubscription = Subscription::where('magazine_id', $magazine->id)
        ->where('user_id', Auth::user()->id)
        ->whereIn('status', ['active', 'pending'])
        ->first();
            if ($existingSubscription) {
                $msg='You are already subscribed to this magazine with an active subscription';
                $status_code=400;
            }
                $subscripe = Subscription::updateOrCreate(
                    [
                        'magazine_id' => $magazine->id,
                        'user_id' => Auth::user()->id,
                    ],
                    [
                        'start_date' => now()->toDateString(),
                        'end_date' => $input_data['end_date'],
                        'status' => 'pending', // إضافة حالة الاشتراك
                    ]
                );
                
                  DB::commit();
                  $data['subscripe']= $subscripe;
                  $msg='تم ارسال طلبك للاشتراك يرجى انتظار رسالة التفعيل';
                  $status_code=200;
                
            }
        
            // إنشاء أو تحديث الاشتراك
         
            
        catch (AuthorizationException $e) {
                DB::rollBack();
                Log::error('Unauthorized access attempt', [
                    'user_id' => Auth::user()->role,
                    'magazine_id' => $magazine->id,
                    'error_message' => $e->getMessage(),
                ]);
            $msg='you are not authorized to perform this action';
            $status_code=403;

          
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
        //payment 
        public function payment(array $input_data ,Subscription $subscription)
        {
            $result=[];
            $data=[];
            $msg='';
            $status_code=400;
            try{
                DB::beginTransaction();

                if ($subscription->user_id != Auth('api')->user()->id) {
                    $status_code = 403;
                    $msg = 'لا يمكنك دفع هذا الاشتراك';
                }              
                
                $payment = Payment::updateOrCreate(
                    [
                        'user_id' => Auth('api')->user()->id,
                        'subscription_id' => $subscription->id,
                    ],
                    [
                        'amount_paid' => $input_data['amount_paid'],
                        'payment_method' => $input_data['payment_method'],
                        'payment_date' =>Carbon:: now()
                    ]
                );
                    DB::commit();
                    $msg='تم الدفع';
                    $status_code=200;
                    $data['payment'] =$payment;
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
        //get articles 

        public function get_articles(Magazine $magazine)
        {
            $result=[];
            $data=[];
            $msg='';
            $status_code=400;
            try{
              //check if user is subscript to view articles
                  $this->authorize('getAricles', $magazine);

                 $article=  $magazine->articles;
                   $data['article'] =$article;
                   $msg='عرض المقالاات';
                   $status_code=200;
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
        //get article 
        public function get_article(Magazine $magazine,Article $article)
        {
            $result=[];
            $data=[];
            $msg='';
            $status_code=400;
            try{
              //check if user is subscript to view articles
                  $this->authorize('getAricles', $magazine);

                   $data['article'] =$article;
                   $msg='عرض المقالة';
                   $status_code=200;
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

        //add comment
        public function add_comment(array $input_data ,Magazine $magazine,Article $article)
        {
            $result=[];
            $data=[];
            $msg='';
            $status_code=400;
            try{
                DB::beginTransaction();
                $this->authorize('getAricles', $magazine);
                $comment=Comment::create([
                    'user_id' => Auth::user()->id,
                    'article_id' => $article->id,
                    'content' => $input_data['content'],
                    'comment_date' => carbon::now()

                ]);
                DB::commit();
                  $data['comment'] =$comment;
                  $msg='اضافة تعليق';
                  $status_code=200;
                       
                
             
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

    }
?>