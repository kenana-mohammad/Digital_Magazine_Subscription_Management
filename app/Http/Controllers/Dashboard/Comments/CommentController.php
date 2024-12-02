<?php

namespace App\Http\Controllers\Dashboard\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BanCommentRequest;
use App\Http\Resources\app\CommentResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Comment;
use Dash_CommentServices;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    //


    use ApiResponseTrait;
    //add magazine if admin or publisher
    public function __construct(protected Dash_CommentServices $comment_services)
    {
     $this->comment_services=$comment_services;

    }
    public function ban_comment(BanCommentRequest $request,Comment $comment)
    {
        $input_data=$request->validated();
        $result=$this->comment_services->ban_comment($input_data,$comment);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            $output['comment'] = new CommentResource($result_data['comment']);
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);
          
    }

}
