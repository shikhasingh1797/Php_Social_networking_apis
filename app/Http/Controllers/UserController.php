<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;
use Hash;
use Session;
use Response;
use Validator;
use Auth;
use DB;
use App\Http\Controllers\PhotoController;

class UserController extends Controller
{
    //
    public function signupUser(Request $request){


        $validator = Validator::make($request->all(), [
            'age'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
            'username'=>'required'
        ]);

        if ($validator->fails()) {
            return Response::json(["status"=>"RXERROR", "message"=>"Unable to register", "errors"=>$validator->messages()],400);
        } 

        $user=new User();
        $user->age=$request->age;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->username=$request->username;
        $res=$user->save();
        $token = $user->createToken('API Token')->accessToken;
        return response([ 'user' => $user, 'token' => $token]);
        if($res){

            return Response::json(["status"=>"RXSUCCESS", "message"=>"User registered successfully", "data"=>$res],200);
        }
        else{
            return Response::json(["status"=>"RXERROR", "message"=>"Unable to register", "errors"=>$res],400);


        }
    }



    public function loginUser(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required',
        ]);
        if ($validator->fails()) {
            return Response::json(["status"=>"RXERROR", "message"=>"Unable to login", "errors"=>$validator->messages()],400);
        } 
 
        $user=User::where('email','=',$request->email)->first();
        if($user!=null && Hash::check($request->password,$user->password)){
            $post=User::with(['socialmedia','photo'=>function($query){
                $query->selectRaw("*,CONCAT('http://localhost','/',photos.photo_url) AS photo_url");
            }])->where('id',$user->id)->get(); 
            return Response::json(["status"=>"RXSUCCESS", "message"=>"User logged in successfully", "data"=> $post],200);
        }
        return Response::json(["status"=>"RXERROR", "message"=>"Invalid Credentials"],400);
    }




    public function profileUpdate(Request $request){
  
        $user=auth()->user();
        try{
            User::where('id',$user->id)->update($request->all());
        }catch(\Exception $e){
            return Response::json(["status"=>"RXERROR", "message"=>$e->getMessage()],400);
        }
        return Response::json(["status"=>"RXSUCCESS", "message"=>"User profile updated successfully", "data"=> $user ],200);
        }
    




        public function profileDelete(Request $request){
            $user=auth()->user();
            try{
                User::where('id',$user->id)->delete($request->all());
            }catch(\Exception $e){
                return Response::json(["status"=>"RXERROR", "message"=>$e->getMessage()],400);
            }
            return Response::json(["status"=>"RXSUCCESS", "message"=>"User profile deleted sucessfully", "data"=> $user ],200);
            }



        public function userphoto(){
            $post=User::with('photo')->get();    
            return Response::json(["status"=>"RXSUCCESS", "message"=>"Post data", "data"=>$post],200);
    
        }
        public function userSocialMedia($id){

            $post=User::with('socialmedia','photo')->where('id',$id)->get();             
            return Response::json(["status"=>"RXSUCCESS", "message"=>"Post data", "data"=>$post],200);
    
        }
   
}