<?php
namespace App\Http\Traits ;

trait GeneralTrait
{

     public function getCurrentLang(){
        return app()->getLocale();
     }

     public function returnError($errNum , $msg)
     {
        return response()->json([
            'status' => false ,
            'errNum' => $errNum ,
            'msg' => $msg ,
        ]);
     }
 
     public function returnSuccessMessage($msg ="" ,$errNum = "000")
     {
        return response()->json([
            'status' => true ,
            'errNum' => $errNum ,
            'msg' => $msg ,
        ]);

     }

     public function returnData($key , $value , $msg="" , $totalPage = null){

        return response()->json([
            'status' => true ,
            'errNum' => '' ,
            'msg' => $msg ,
            $key => $value,
            'totalPage' => $totalPage
        ]);

     }

    

}
