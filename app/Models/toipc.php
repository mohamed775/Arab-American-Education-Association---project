<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class toipc extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [

        'name',
        'img' ,
        
    ];

    public function skill(){
        return $this->hasMany(skill::class ,'topic_id');
    }

    // public function getImageURL(){
    //     if($this->img){
    //         return url('storage/'.$this->img);
    //     }
    // }

    

}
