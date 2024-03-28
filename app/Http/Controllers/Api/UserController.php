<?php

namespace App\Http\Controllers\Api;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Controllers\Controller;
use App\Http\Resources\topicResource;
use App\Http\Resources\userResource;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Auth;

class UserController extends authController 
{

    use GeneralTrait ;


    // return user profile 
    
    public function userProfile($id){
      try{
        $userProfile = User::with('profile')->find($id);
        $userProfile = userResource::make($userProfile);
        if(isset($userProfile)){
          return $this->returnData('data' ,$userProfile , ' data retrived success' );
        }
        return $this->returnError('E000' , 'user profile not found ');

      }catch(\Exception $e){
        return $this->returnError('E001' ,$e->getMessage() );
      }
          
    }

    // show my profile 
    public function myProfile(){
      try{
        if(!auth()->user())
        {
          return $this->returnError('E000' ,'not authanticated' );
        }
        $user = userResource::make(auth()->user()) ;
        $user->profile;
        return $this->returnData('data' , $user , 'my profile data' );
      }catch(\Exception $e){
        return $this->returnError('E001' ,$e->getMessage() );
      }
          
    }

    // public function sendVerifyMail($email){

    //   if(auth()->user()){
    //    $user =  User::where('email',$email )->get();
    //    if(count($user)>0){

    //     $random = Str::random(40);
    //     $domin = URL::to('/');
    //     $url = $domin.'/'.$random ;

    //     $data['url'] = $url ;
    //     $data['email']= $email;
    //     $data['title'] = 'email verified';
    //     $data['body'] = 'please verify your email';

    //     Mail::send('email',['data'=> $data] ,function($message) use ($data){
    //       $message->to($data['email'])->subject($data['title']);
    //     });

    //     $user = User::find($user[0]['id']);
    //     $user->remember_token = $random ;
    //     $user->save();

    //     return response()->json([
    //       'success' => true ,
    //       'msg' => 'mail sent successfully'
    //     ]);

    //    }
    //    else{
    //     return response()->json([
    //       'success' => false ,
    //       'msg' => 'user not found'
    //     ]);
    //    }
    //   }
    //   else{
    //     return response()->json([
    //       'success' => false ,
    //       'msg' => 'user not authanticated'
    //     ]);
    //   }
    // }


    // protected function respondWithToken($token)
    // {
    //   return response()->json([
    //     'success' => true ,
    //     'access_token' => $token ,
    //     'token_type'=> 'Bearer' 
    //   ]);
    // }


//  get all user 

    public function getAllUser(){

      try{

        $user = User::select()->paginate(PAGINATION_COUNTER);
        
        return $this->returnData('data' , $user ,'all users retived' );

      }catch(\Exception $e){
        return $this->returnError('E001' ,$e->getMessage() );
      }
    }


    // get one user 
    public function getUserById($id){
      try{

          $user = User::find($id);
          
          if(isset($user))
          {
            return $this->returnData('data' , userResource::make($user) ,' user Details' );
          }
          return $this->returnError('404' ,'user not found' );

      }catch(\Exception $e){
                 return $this->returnError('E001' ,$e->getMessage() );
      }
  }


// add user

  public function addUser(Request $request)
  {
      try{
          $validate=  Validator::make($request->all(),[
              'name' => 'required|string|min:2|max:100',
              'email' => 'required|email|min:2|max:100 |unique:users,email',
              'img' => 'required|image',
              'coverImg' => 'required|image',
              'password' => 'required|confirmed|min:6|max:20',
              ]);
              if($validate->fails())
              {
                  return $this->returnError('E000' , $validate->errors());
              }
      
              $img = $this->getImage($request);
              $cover = $this->getCoverImage($request);
             
              $user = new User();
              $user->name = $request->name;
              $user->email = $request->email;
              $user->password =Hash::make( $request->password);
              $user->img = $img;
              $user->coverImg = $cover;
              $user->save();
              return $this->returnData('user' , userResource::make($user) , 'user added success');
      }catch(\Exception $e){
          return $this->returnError('E001' ,$e->getMessage() );
      }
     
  }

  // delete user 

  public function deleteUser($id)
  {
      try{
          
          $user = User::find($id);
          if(isset($user)){
             $user->delete();
             return $this->returnSuccessMessage('user deleted sucessfully' , '');
          }
          return $this->returnError('E0001' , ' user not found');
      }catch(\Exception $e){
          return $this->returnError('E001' ,$e->getMessage() );
      }
     
  }


  // update user 
  public function updateUser(Request $request,$id)
  {
      try{
        $validate=  Validator::make($request->all(),[
          'name' => 'required|string|min:2|max:100',
          'email' => 'required|email|min:2|max:100 |unique:users,email',
          'img' => 'required|image',
          'coverImg' => 'required|image',
          'password' => 'required|confirmed|min:6|max:20',
          ]);
          if($validate->fails())
          {
              return $this->returnError('E000' , $validate->errors());
          }
          $user = User::find($id);

          if($user){
            $img = $this->getImage($request);
            $cover = $this->getCoverImage($request);
  
           $user = new User();
           $user->name = $request->name;
           $user->email = $request->email;
           $user->password = $request->password;
           $user->img = $img;
           $user->coverImg = $cover;
           $user->save();
  
          return $this->returnData('user' , userResource::make($user) , 'user added success');
          }
          return $this->returnError('404' ,'user not found' );
      }catch(\Exception $e){
          return $this->returnError('E001' ,$e->getMessage() );
      }
  }

  public function search()
    {
        $search = request('user');
        $user = User::select()->where(function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->paginate(PAGINATION_COUNTER);
        return response()->json([
            $user,
            'code'=> 200],
            200);
    }

  
  

}
