<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userProfile extends Model
{
    use HasFactory;
    protected $hidden=['created_at','updated_at','deleted_at'];


    public function user(){
        return $this->belongsTo(User::class );
    }
}
