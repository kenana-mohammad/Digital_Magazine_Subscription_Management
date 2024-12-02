<?php
    namespace App\Services\Dashboard;

use App\Models\Subscription;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

    class Dash_SubscripationServices
    {
        use AuthorizesRequests;

        public function get_subscraptions()
        {
            $result=[];
            $data=[];
            $status_code = 400;
              $msg='';
              
              $this->authorize('viewAny', Subscription::class);

// Basic query caching
$subscraptions = Cache::remember('subscriptions', 60, function () {
    return Subscription::get();
});
         $data['subscraptions']=$subscraptions;
         $status_code=200;
         $msg='تم استعراض الاشتراكات';

$result = [
    'data' => $data,
    'status_code' => $status_code,
    'msg' => $msg,
];

return $result;
        }
        //---------------------

        //change status 
        public function change_status_subscripte(array $input_data , Subscription $subscription)
        {
            $result=[];
            $data=[];
            $status_code = 400;
              $msg='';
              try{
                 
                DB::beginTransaction();
                $this->authorize('change_status', $subscription);

                $newData=[];
                if(isset($input_data['status'])){
                    $newData['status']=$input_data['status'];
                }
                $subscription->update($newData);
                    DB::commit();
                     $msg='تم تغيير الحالة';
                     $status_code=200;
                     $data['subscription']=$subscription;

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
        //delete
        public function delete_subscripte(Subscription $subscription)
        {
           $result = [];
           $msg = '';
           $data = [];
           $status_code = 400;
           $this->authorize('delete', $subscription);

          if(!$subscription){
           $status_code=404;
           $msg='الاشتراك غير موجود';

          }
          $subscription->delete();
          $status_code=200;
          $msg=' الحذف بنجاح';
           $result = [
               'data' => $data,
               'status_code' => $status_code,
               'msg' => $msg,
           ];
       
           return $result;
        }
        

        
    }
?>