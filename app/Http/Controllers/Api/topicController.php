<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\profileResource;
use App\Http\Resources\topicResource;
use App\Http\Traits\GeneralTrait;
use App\Models\skill;
use App\Models\toipc;
use App\Models\userProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class topicController extends Controller
{
    use GeneralTrait;


    // get all general topic 

    public function getAllTopic(){
        try{
            $topic = toipc::select()->paginate(PAGINATION_COUNTER);
            return $this->returnData('data' , $topic ,'all topics retived'.' ' .count($topic)  );

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }    
    }

    //  get specific topic with interna skill 

    public function getTopic($id){

        try{
            $topic = toipc::with('skill')->find($id);
            if($topic){
                $topic = topicResource::make($topic);
                return $this->returnData('data' , $topic ,' topic retived');
            }
                
            return $this->returnError('E001' , 'topic not found' );

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }   
    }


    // add new topic

    public function addTopic(Request $request)
    {
        try{
            $validate=  Validator::make($request->all(),[
                'name' => 'required|string|min:2|max:100 |unique:toipcs',
                'img' => 'required|image',
                ]);

                if($validate->fails())
                {
                    return $this->returnError('E000' , $validate->errors());
                }

                $img = $this->getImage($request);
                $topic = new toipc();
                $topic->Name = $request->name;
                $topic->img = $img;
                $topic->save();

                return $this->returnData('topic' , topicResource::make($topic) , 'topic added success');

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }
    }

    // delete topic 

    public function deleteTopic($id)
    {
        try{    
            $topic = toipc::find($id);
            if(isset($topic)){
               $topic->delete();
               return $this->returnSuccessMessage('topic deleted sucessfully' , '');
            }
            return $this->returnError('E0001' , ' topic not found');
        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }
       
    }


    // update topic 
    public function updateTopic(Request $request,$id)
    {
        try{
            $validate=  Validator::make($request->all(),[
                'name' => 'required|string|min:2|max:100 |unique:toipcs',
                'img' => 'required|image',
                ]);
            if($validate->fails())
                {
                    return $this->returnError('E000' , $validate->errors());
                }
            $topic = toipc::find($id);
            if($topic) {
                $topic->Name = $request->name ;
                $img = $this->getImage($request);
                $topic->img = $img ;
                $topic->save();
                return $this->returnData('data' , topicResource::make($topic) ,'topic updated successfully');
            }

            return $this->returnError('404' , ' topic not found');

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }
    }

    // search in topic bu character

    public function search()
    {
        $search = request('topic');
        $topic = toipc::select()->where(function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->paginate(PAGINATION_COUNTER);
        return response()->json([
            $topic,
            'code'=> 200],
            200);
    }



    protected function getImage($request)
     {
         $img = $request->file('img');
         $imgPath = $img->store('topic','public');
         $image =  '/storage/'.$imgPath ;

         return $image ;
     }


}
