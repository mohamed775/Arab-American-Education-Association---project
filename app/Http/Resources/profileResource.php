<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class profileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return[
            "img"=>  $this->img,
            "cover" =>  $this->coverImg,
            "coins"=>  $this->coins,
            "rating"=>  $this->rating,  
            "user" => userResource::make($this->whenLoaded('user'))    
        ];
    }
}
