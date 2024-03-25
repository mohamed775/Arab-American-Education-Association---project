<?php

// use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\api\authController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\topicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





// Route::middleware('auth:api')->get('/user', function(){

//     return $Request->user();
// });



// Route::group(['middleware' => ['api' ,'changeLang']] , function(){

//     Route::get('category' , [CategoriesController::class , 'index']);
//     Route::get('getCategorybyId' , [CategoriesController::class , 'getCategorybyId']);

//     Route::group(['prefix' => 'admin'],function(){
//         Route::get('login' , [AuthController::class , 'login']);
//         Route::get('logout' , [AuthController::class , 'logout']);

//     });


// });



// Route::group(['middleware' => ['api' , 'checkpassword' ,'changeLang' , 'checkAdminToken:admin-api']] , function(){
//     Route::get('offers' , [CategoriesController::class , 'index']);
// });


// Route::post('add' , [AuthController::class , 'addUser']);



// route for Auth 

Route::group(['middleware' => 'api'] , function(){

    Route::post('/rigester' , [authController::class , 'rigester']);
    Route::get('/login' , [authController::class , 'login']);
    Route::get('/logout' , [authController::class , 'logout']);

});


// user route
Route::middleware('auth:api')->group(function(){

    Route::get('/user' , [UserController::class , 'getAllUser']);
    Route::get('/user/{id}' , [UserController::class , 'getUserById']);
    Route::Post('/user' , [UserController::class , 'addUser']);
    Route::delete('/user/{id}' , [UserController::class , 'deleteUser']);
    Route::put('/user/{id}' , [UserController::class , 'updateUser']);
    Route::get('/profile' , [UserController::class , 'myProfile']);
    Route::get('/user/{id}/profile' , [UserController::class , 'userProfile']);


});

// route for topic and skills 

Route::middleware('auth:api')->group(function(){

    Route::get('/topic' , [topicController::class , 'getAllTopic']);
    Route::Post('/topic' , [topicController::class , 'addTopic']);
    Route::get('/topic/{id}' , [topicController::class , 'getTopic']);
    Route::delete('/topic/{id}' , [topicController::class , 'deleteTopic']);
    Route::put('/topic/{id}' , [topicController::class , 'updateTopic']);

    /////////////////////////////

    Route::get('/skill' , [topicController::class , 'getAllSkill']);
    Route::get('/skill/{id}' , [topicController::class , 'getSkill']);
    Route::get('/skill/{id}/users' , [topicController::class , 'getUserBySkill']);
    Route::Post('/skill' , [topicController::class , 'addSkill']);
    Route::delete('/skill/{id}' , [topicController::class , 'deleteSkill']);
    Route::put('/skill/{id}' , [topicController::class , 'updateSkill']);

});

