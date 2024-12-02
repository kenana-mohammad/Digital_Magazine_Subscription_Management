<?php

use App\Models\Comment;

    class Dash_CommentServices{
        public function ban_comment(array $input_data,Comment $comment)
        {
            $data = [];
            $status_code = 400;
            $msg = '';
            $result = [];
    
           if ($comment->is_blocked) {
                $status_code = 400;
                $msg = 'Selected comment is already Banned';
            } else {
                $comment->update(['is_blocked' => true]);
    
                $status_code = 200;
                $msg = 'comment Banned';
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