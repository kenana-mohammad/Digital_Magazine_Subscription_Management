<?php
namespace App\Services\Dashboard;

use App\Models\Article;
use App\Models\Magazine;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

    class Dash_ArticleServices
    {
        use AuthorizesRequests;

        public function add_article(array $input_data,Magazine $magazine)
        {
            $result=[];
            $msg='';
            $data=[];
            $status_code=400;
            try{
                //use policy if user can create by authorize
                $this->authorize('add_article', $magazine);

                $article=Article::create([
                 'title' => $input_data['title'],
                 'content' => $input_data['content'],
                   'magazine_id' => $magazine->id,
                   'publication_date' => now()

                ]);
                $data['article'] = $article;
                $status_code=200;
                $msg='تم اضافة المقال';
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
    }
?>