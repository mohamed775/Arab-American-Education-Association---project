<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skill extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [

        'name',
        'img' ,
        'topic_id'
    ];

    public function topic(){
        return $this->belongsTo(toipc::class ,'topic_id' );
    }

    public function user(){
        return $this->belongsToMany(User::class , 'skill_id ' );
    }
}
