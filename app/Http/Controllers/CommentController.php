<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\Comment;
use Response;
use DB;

class CommentController extends Controller
{
    //
    public function postComment(Request $request,$id){
        $user=auth()->user(); 
        $user_id=$user->id;
        $comment = new Comment();
        $comment->user_id = $user_id;
        $comment->post_id = $id;
        $comment->comment=$request['comment'];
        $comment->save();
        if($comment){

            return Response::json(["status"=>"RXSUCCESS", "message"=>"User registered successfully", "commentData"=>$comment],200);
        }
        else{
            return Response::json(["status"=>"RXERROR", "message"=>"Unable to register", "errors"=>$res],400);


        }
    }
    public function getAllComments(Request $request)
    {
        $allComments=DB::select('select * from comments');
        return ($allComments);
    } 



    public function updateComment(Request $request,$id)
    {
        $commentData=$request->all();
        try{
            $result=Comment::where('id',$id)->update(array('comment' =>$commentData['comment']));
        }catch(\Exception $e){
            return Response::json(["status"=>"RXERROR", "message"=>$e->getMessage()],400);
        }
        return Response::json(["status"=>"RXSUCCESS", "message"=>"Comment updated successfully", "comment"=> $commentData],200);
    } 

    public function deleteComment($id) {
        // DB::table('comments')->where('id',$id)->delete();
        try{
            DB::table('comments')->where('id',$id)->delete();
        }catch(\Exception $e){
            return Response::json(["status"=>"RXERROR", "message"=>$e->getMessage()],400);
        }
        return Response::json(["status"=>"RXSUCCESS", "message"=>"Comment deleted successfully"],200);
    }
}