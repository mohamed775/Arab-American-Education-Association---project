<?php

namespace App\Http\Controllers;

use App\Http\Resources\profileResource;
use App\Http\Resources\topicCollection;
use App\Http\Resources\topicResource;
use App\Http\Traits\GeneralTrait;
use App\Models\skill;
use App\Models\toipc;
use App\Models\User;
use App\Models\userProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

use function Laravel\Prompts\error;

class topicController extends Controller
{
    use GeneralTrait;


    // get all general topic 

    public function getAllTopic(){
        try{
            

            $topic = toipc::get();
            $topic =  topicCollection::make($topic);
            if(!auth()->user())
            {
                return $this->returnError('E000' ,'not authanticated' );
            }
            return $this->returnData('data' , $topic ,'all topics retived'.' ' .count($topic)  );

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }    
    }


    //  get specific topic with interna skill 

    public function getTopic($id){

        try{
            $topic = toipc::with('skill')->find($id);
            $topic = topicResource::make($topic);
            if(!auth()->user())
            {
                return $this->returnError('E000' ,'not authanticated' );
            }

            return $this->returnData('data' , $topic ,' topic retived');

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
        
                if(Request()->has('img')){
                    $imagePath = $request->img->store('topic','public');
                    $image =  '/storage/'.$imagePath ;
                }
                $topic = new toipc();
                $topic->Name = $request->name;
                $topic->img = $image;
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
            // return response()->json($topic);
            $topic->Name = $request->name ;
            if(Request()->has('img')){
                $imagePath = $request->img->store('topic','public');
                $image = '/storage/'.$imagePath ;
                $topic->img = $image ;
               } 
            $topic->save();
            return $this->returnData('data' , topicResource::make($topic) ,'topic updated successfully');
            // return $this->returnError('E0001' , ' topic not found');
        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }
    }


//////////////////////////////////////////////////////////////////////////////////////////

//skill 
    // get all skills 

    public function getAllSkill(){
        try{
            $skill = skill::get();
            $skill = topicCollection::make($skill);
            if(!auth()->user())
            {
                return $this->returnError('E000' ,'not authanticated' );
            }
            return $this->returnData('data' , $skill ,'all skills retived'.' ' .count($skill)  );

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        } 
    }


    // get one skill 

    public function getSkill($id){
        try{
            $skill = skill::find($id);
            $skill = topicResource::make($skill);
            if(!auth()->user())
            {
                return $this->returnError('E000' ,'not authanticated' );
            }
            return $this->returnData('data' , $skill ,' skill retived');

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }
    }


    public function getUserBySkill($id){
        try{
            $data = userProfile::where('skill_id', $id )->with('user')->get();
            $data = profileResource::collection($data);
            if(!auth()->user())
            {
              return $this->returnError('E000' ,'not authanticated' );
            }
            if($data){
                return $this->returnData('data' , $data , 'all retrived'. "  "  . (count($data)));
            }
            return $this->returnSuccessMessage('not user found in this skill','0' );
        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }
    }

        // add new skill

        public function addSkill(Request $request)
        {
            try{
                $validate=  Validator::make($request->all(),[
                    'name' => 'required|string|min:2|max:100 |unique:skills',
                    'img' => 'required|image',
                    'topic_id' => 'required|int'
                    ]);
                    if($validate->fails())
                    {
                        return $this->returnError('E000' , $validate->errors());
                    }
            
                    if(Request()->has('img')){
                        $imagePath = $request->img->store('skill','public');
                        $image =  '/storage/'.$imagePath ;
                    }
                    $skill = new skill();
                    $skill->Name = $request->name;
                    $skill->img = $image;
                    $skill->topic_id = $request->topic_id;
                    $skill->save();
                    return $this->returnData('skill' , topicResource::make($skill) , 'skill added success');
            }catch(\Exception $e){
                return $this->returnError('E001' ,$e->getMessage() );
            }
           
        }
    
        // delete skill 
    
        public function deleteSkill($id)
        {
            try{
                
                $skill = skill::find($id);
                if(isset($skill)){
                   $skill->delete();
                   return $this->returnSuccessMessage('skill deleted sucessfully' , '');
                }
                return $this->returnError('E0001' , ' skill not found');
            }catch(\Exception $e){
                return $this->returnError('E001' ,$e->getMessage() );
            }
           
        }
    
    
        // update skill 
        public function updateSkill(Request $request,$id)
        {
            try{
                $validate=  Validator::make($request->all(),[
                    'name' => 'required|string|min:2|max:100 |unique:skills',
                    'img' => 'required|image',
                    'topic_id' => 'required|int'
                    ]);
                if($validate->fails())
                    {
                        return $this->returnError('E000' , $validate->errors());
                    }
                $skill = skill::find($id);
                // return response()->json($topic);
                $skill->Name = $request->name ;
                $skill->topic_id = $request->topic_id;
                if(Request()->has('img')){
                    $imagePath = $request->img->store('skill','public');
                    $image = '/storage/'.$imagePath ;
                    $skill->img = $image ;
                   } 
                $skill->save();
                return $this->returnData('data' , topicResource::make($skill) ,'skill updated successfully');
            }catch(\Exception $e){
                return $this->returnError('E001' ,$e->getMessage() );
            }
        }

}
