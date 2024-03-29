<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\profileResource;
use App\Http\Resources\topicResource;
use App\Http\Traits\GeneralTrait;
use App\Models\skill;
use App\Models\userProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class skillController extends Controller
{
    use GeneralTrait;

    // get all skill 

    public function getAllSkill(){
        try{
            $skill = skill::select('id' ,'name_'.app()->getLocale() , 'img' , 'topic_id')->paginate(8);
            $totalPage = $skill->lastPage();
            return $this->returnData('data' , $skill ,'all skills retived'.' ' .count($skill) ,$totalPage)  ;

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        } 
    }


    // get one skill 

    public function getSkill($id){
        try{
            $skill = skill::find($id);
           
            if($skill){
                return $this->returnData('data' , topicResource::make($skill) ,' skill retived');
            }
            return $this->returnError('404' ,'skill not found' );

        }catch(\Exception $e){
            return $this->returnError('E001' ,$e->getMessage() );
        }
    }


   // get all user that teach this skill

    public function getUserBySkill($id){
        try{
            $data = userProfile::where('skill_id', $id )->with('user')->paginate(8);
            $data = profileResource::collection($data);  
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
                    'name_en' => 'required|string|min:2|max:100 |unique:toipcs',
                    'name_ar' => 'required|string|min:2|max:100 |unique:toipcs',
                    'img' => 'required|image',
                    'topic_id' => 'required|int'
                    ]);
                    if($validate->fails())
                    {
                        return $this->returnError('E000' , $validate->errors());
                    }
            
                    $img = $this->getImage($request);

                    $skill = new skill();
                    $skill->name_en = $request->name_en;
                    $skill->name_ar = $request->name_ar;
                    $skill->img = $img;
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
                if($skill){
                   $skill->delete();
                   return $this->returnSuccessMessage('skill deleted sucessfully' , '');
                }
                return $this->returnError('404' , ' skill not found');
            }catch(\Exception $e){
                return $this->returnError('E001' ,$e->getMessage() );
            }
           
        }
    
    
        // update skill 
        public function updateSkill(Request $request,$id)
        {
            try{
                $validate=  Validator::make($request->all(),[
                    'name_en' => 'required|string|min:2|max:100 |unique:toipcs',
                    'name_ar' => 'required|string|min:2|max:100 |unique:toipcs',
                    'img' => 'required|image',
                    'topic_id' => 'required|int'
                    ]);
                if($validate->fails())
                    {
                        return $this->returnError('E000' , $validate->errors());
                    }

                $img = $this->getImage($request);
                $skill = skill::find($id);
                if($skill){
                    $skill->name_en = $request->name_en;
                    $skill->name_ar = $request->name_ar;
                    $skill->topic_id = $request->topic_id;
                    $skill->img = $img ;
                    $skill->save();
                    return $this->returnData('data' , topicResource::make($skill) ,'skill updated successfully');
                }

                 return $this->returnError('404' ,'skill not found' );

            }catch(\Exception $e){
                return $this->returnError('E001' ,$e->getMessage() );
            }
        }

    public function search()
    {
        $search = request('skill');
        $skill = skill::select()->where(function ($query) use ($search) {
            $query->where('name_'.app()->getLocale(), 'LIKE', '%' . $search . '%');
        })->paginate(8);
        return response()->json([
            $skill,
            'code'=> 200],
            200);
    }

     protected function getImage($request)
     {
         $img = $request->file('img');
         $imgPath = $img->store('skill','public');
         $image =  '/storage/'.$imgPath ;

         return $image ;
     }
}
