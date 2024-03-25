<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{

    use GeneralTrait;
    

    // register 
    public function rigester(Request $request){

        $valideted =  Validator::make($request->all() , [
         'name' => 'required|string|min:2|max:100',
         'email' => 'required|string|email|max:100|unique:users',
         'password' => 'required|confirmed|min:6|string'
        ] );
 
        if($valideted->fails())
        {
            return $this->returnError('E000' , $valideted->errors());
        //   return response()->json($valideted->errors());
        }
        $user = User::create([
             'name' =>$request->name ,
             'email' => $request->email,
             'password' => Hash::make($request->password ) 
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
         auth()->logout();
         return $this->returnSuccessMessage('user logged out' ,'000');
     }
 
}
