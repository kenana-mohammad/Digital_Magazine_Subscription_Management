<?php

namespace App\Http\Controllers\Dash_Publish;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Resources\Common\Article\ArticleResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Magazine;
use App\Services\Dashboard\Dash_ArticleServices;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    use ApiResponseTrait;
    public function __construct(protected Dash_ArticleServices $dash_article_services)
    {
       $this->dash_article_services=$dash_article_services;
    }

    public function add_article(CreateArticleRequest $request,Magazine $magazine)
    {
        $input_data=$request->validated();
        $result=$this->dash_article_services->add_article($input_data,$magazine);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['article'] = new ArticleResource($result_data['article']);
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);        
    }
}
