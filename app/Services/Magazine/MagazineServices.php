<?php

    namespace App\Services\Magazine;

use Auth;
use Exception;
use App\Models\Magazine;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    class MagazineServices
    {
        use AuthorizesRequests;

        //get all magazine
        
         public function get_magazines()
                  {
                    $result=[];
                    $msg='';
                    $data=[];
                    $status_code=400;
try{


                    $this->authorize('viewAny', Magazine::class);

                    $magazines=Magazine::get();
                    $data['magazines']=$magazines;
                    $msg='تم استرداد جميع المجلدات';
                    $status_code=200;
}catch (\Illuminate\Auth\Access\AuthorizationException $e) {
    // معالجة استثناء الصلاحيات
    Log::error('Authorization error: ' . $e->getMessage());
    $status_code = 403;
    $msg = 'عذرًا، ليس لديك الصلاحية لعرض المجلات.';
} catch (\Exception $e) {
    // معالجة أي خطأ آخر
    Log::error('Error fetching magazines: ' . $e->getMessage());
    $status_code = 500;
    $msg = 'حدث خطأ أثناء استرداد المجلات.';
}

                    $result = [
                        'data' => $data,
                        'status_code' => $status_code,
                        'msg' => $msg,
                    ];
            
                    return $result;
         }
         public function create_magazine(array $input_data)
         {
            $result=[];
            $msg='';
            $data=[];
            $status_code=400;
            try{
                //use policy if user can create by authorize
                $this->authorize('create', Magazine::class);

                $magazine=Magazine::create([
                 'name' => $input_data['name'],
                 'description' => $input_data['description'],
                   'release_date' => $input_data['release_date']
                ]);
                $data['magazine'] = $magazine;
                $status_code=200;
                $msg='تم اضافة المجلة';
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

         //
         public function update_magazine(array $input_data, $magazine)
         {
             $result = [];
             $msg = '';
             $data = [];
             $status_code = 400;
         
             try {
                 // جلب المجلة من قاعدة البيانات
         
                 Log::debug('Starting Authorization Check...');
                 $this->authorize('update', $magazine);
                 Log::debug('Authorization Passed!');
         
                 // إعداد البيانات الجديدة
                 $newData = [];
                 if (isset($input_data['name'])) {
                     $newData['name'] = $input_data['name'];
                 }
                 if (isset($input_data['description'])) {
                     $newData['description'] = $input_data['description'];
                 }
                 if (isset($input_data['release_date'])) {
                     $newData['release_date'] = $input_data['release_date'];
                 }
         
                 // تحديث البيانات
                 $magazine->update($newData);
         
                 // إعداد الرد
                 $data['magazine'] = $magazine;
                 $status_code = 200;
                 $msg = 'تم تعديل المجلة بنجاح';
             } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
                 Log::error('Authorization error: ' . $e->getMessage());
                 $status_code = 403;
                 $msg = 'ليس لديك الصلاحية لتعديل هذه المجلة';
             } catch (\Exception $e) {
                 Log::error('Error updating magazine: ' . $e->getMessage());
                 $status_code = 500;
                 $msg = 'حدث خطأ أثناء تحديث المجلة';
             }
         
             $result = [
                 'data' => $data,
                 'status_code' => $status_code,
                 'msg' => $msg,
             ];
         
             return $result;
         }
         //delete magazine
         public function delete_magazine(Magazine $magazine)
         {
            $result = [];
            $msg = '';
            $data = [];
            $status_code = 400;
            $this->authorize('delete', $magazine);

           if(!$magazine){
            $status_code=404;
            $msg='المجلة غير موجودة';

           }
           $magazine->delete();
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