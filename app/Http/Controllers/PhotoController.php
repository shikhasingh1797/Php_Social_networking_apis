<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Photo;
use App\Models\User;
use Auth;
use DB;
// use Illuminate\Support\Facades\DB;
use Response;

class PhotoController extends Controller
{
    //
    public function upload(Request $request)

    {
        $user=auth()->user();     
        $file=$request->file('photo_url')->store('',['disk' => 'public']);
        $file="images/".$file;
        $photo = new Photo();
        $photo->title=$request->title;
        $photo->photo_url=$file;
        $photo->user_id=$user->id;
        $photo->save();
  
    }



    public function getAllPhotos(Request $request)
    {
        $results =DB::select(DB::raw("SELECT * FROM photos"));
        return $results;  
    }



    public function updatePhotos(Request $request)
    {
      
        $user=auth()->user();
        $file=$request->file('photo_url')->store('',['disk' => 'public']);
        $file="images/".$file;     
        $photo_id=$request["photo_id"];
        $result=Photo::where('id',$photo_id)->where('user_id',$user->id)->update(array('title' =>$request->title,'photo_url'=>$file));
        if($result){
            return Response::json(["status"=>"RXSUCCESS", "message"=>"User profile updated successfully", "data"=> $user],200);
        }
        else{
            return Response::json(["status"=>"RXERROR", "message"=>$e->getMessage()],400);
        }
    }


    public function deletePhotos($id){
        // DB::table('photos')->where('id',$id)->delete();
        if($id){
            DB::table('photos')->where('id',$id)->delete();
            return Response::json(["status"=>"RXSUCCESS", "message"=>"User profile deleted successfully"],200);
        }
        else{
            return Response::json(["status"=>"RXERROR", "message"=>$e->getMessage()],400);
        }
    }

}
