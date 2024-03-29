<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDO;

class authController extends Controller
{

    use GeneralTrait;
    

    // register  new user 

    public function rigester(Request $request){

        $valideted =  Validator::make($request->all() , [
         'name' => 'required|string|min:2|max:100',
         'email' => 'required|string|email|max:100|unique:users',
         'password' => 'required|confirmed|min:6|string' ,
         'img' => 'image',
         'coverImg' => 'image'
        ] );
 
        if($valideted->fails())
        {
            return $this->returnError('E000' , $valideted->errors());
        }

        $img = $this->getImage($request);
        $coverImg = $this->getCoverImage($request);

        $user = User::create([
             'name' =>$request->name ,
             'email' => $request->email,
             'password' => Hash::make($request->password ) ,
             'img' => $img ,
             'coverImg' => $coverImg

         ]);
         return $this->returnData('user' ,$user , 'insert successfully' );
     }



     //login 
      
     public function login(Request $request){
         
         $valideted =  Validator::make($request->all() , [
             'email' => 'required|string|email',
             'password' => 'required'
            ] );
     
            if($valideted->fails())
            {
                return $this->returnError('e000' , $valideted->errors() );
            }
            if(!$token = auth()->attempt($valideted->validate()))
            {
                return $this->returnError('e000' , 'user & password is incorrect' );
            }

            return $this->returnData('access_token' , $token ,'login success');
     }


     // logout
      
     public function logout(){
        if(Auth::user()){
            auth()->logout();
            return $this->returnSuccessMessage('user logged out' ,'000');
        }
        return $this->returnError('401' ,'user not auth');
     }


     // take img and store it in img folder after that retrive path (user profile )
     protected function getImage($request)
     {
         $img = $request->file('img');
         $imgPath = $img->store('user','public');
         $image =  '/storage/'.$imgPath ;

         return $image ;
     }


     // take img and store it in img folder after that retrive path (cover profile )
     protected function getCoverImage($request)
     {
         $cover = $request->file('coverImg');
         $coverPath = $cover->store('user','public');
         $coverImg =  '/storage/'.$coverPath ;

         return $coverImg ;
     }
 
}
