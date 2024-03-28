<?php

// use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\api\authController;
use App\Http\Controllers\Api\skillController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\topicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




define('PAGINATION_COUNTER',8);


Route::group(['middleware' => ['changeLang' , 'cors']] , function(){

// route for Auth 

   Route::post('/rigester' , [authController::class , 'rigester']);
   Route::get('/login' , [authController::class , 'login']);


// auth route user or admin must be login and have account to can access data and edit  

 Route::middleware('checkAdminToken')->group(function(){

   Route::Post('/user' , [UserController::class , 'addUser']);
   Route::delete('/user/{id}' , [UserController::class , 'deleteUser']);
   Route::put('/user/{id}' , [UserController::class , 'updateUser']);

   Route::delete('/topic/{id}' , [topicController::class , 'deleteTopic']);

   Route::delete('/skill/{id}' , [skillController::class , 'deleteSkill']);

  }); 


//  user API

   Route::get('/profile' , [UserController::class , 'myProfile']); // my profile 
   Route::get('/user' , [UserController::class , 'getAllUser']); // retive all data for all user 
   Route::get('/user/{id}' , [UserController::class , 'getUserById']); // retrive user by ID
   Route::get('/user/{id}/profile' , [UserController::class , 'userProfile']); // show user profile
   Route::get('/user/search' , [skillController::class , 'search']); // search for specific user
   Route::get('/logout' , [authController::class , 'logout']); // logout

// topic API

  Route::get('/topic' , [topicController::class , 'getAllTopic']); // retive all data for all topic 
  Route::get('/topic/{id}' , [topicController::class , 'getTopic']); // retrive tpoic by ID with internal skills
  Route::put('/topic/{id}' , [topicController::class , 'updateTopic']);
  Route::Post('/topic' , [topicController::class , 'addTopic']); 
  Route::get('/topic/search' , [skillController::class , 'search']); // search for specific topic


// skill API 

  Route::get('/skill' , [skillController::class , 'getAllSkill']);
  Route::get('/skill/{id}' , [skillController::class , 'getSkill']); // retrive skill by ID 
  Route::get('/skill/{id}/users' , [skillController::class , 'getUserBySkill']);// retrive skill by ID with users that learn this skill 
  Route::Post('/skill' , [skillController::class , 'addSkill']);
  Route::put('/skill/{id}' , [skillController::class , 'updateSkill']);
  Route::get('/skill/search' , [skillController::class , 'search']);// search for specific skill


});
  



