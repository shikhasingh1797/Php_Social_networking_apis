<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\SocialMedia;
use Response;
use DB;
class SocialMediaController extends Controller
{
    //
    public function postSocialMedia(Request $request){
        $user=auth()->user(); 
        $user_id=$user->id;
        $socialmedia = new SocialMedia();
        $socialmedia->user_id = $user_id;
        $socialmedia->name = $request->name;
        $socialmedia->social_media_url=$request->social_media_url;
        $res=$socialmedia->save();
        if($res){

            return Response::json(["status"=>"RXSUCCESS", "message"=>"Media posted successfully", "socialMediaData"=>$socialmedia],200);
        }
        else{
            return Response::json(["status"=>"RXERROR", "message"=>"Unable to register", "errors"=>$res],400);
        }
    }



    public function getAllSocialMedias(Request $request)
    {
        $allComments=DB::select('select * from social_media');
        return ($allComments);
    } 


    public function updateSocialMedia(Request $request,$id)
    {
        $mediaData=($request->all());
        $result=SocialMedia::where('id',$id)->update(array('name' =>$request['name'],'social_media_url'=>$request['social_media_url']));
        if($result){

            return Response::json(["status"=>"RXSUCCESS", "message"=>"Social media updated successfully", "mediaData"=>$mediaData],200);
        }
        else{
            return Response::json(["status"=>"RXERROR", "message"=>"Unable to register", "errors"=>$mediaData],400);
        }
    } 



    public function deleteSocialMedia($id) {
        try{
            DB::table('social_media')->where('id',$id)->delete();
        }catch(\Exception $e){
            return Response::json(["status"=>"RXERROR", "message"=>$e->getMessage()],400);
        }
        return Response::json(["status"=>"RXSUCCESS", "message"=>"Social media deleted successfully"],200);
    }
}
