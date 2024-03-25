<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class topicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return[
            'id' => $this->id ,
            'name' => $this->Name ,
            'img' => $this->img ,
            'skill' => topicResource::collection($this->whenLoaded('skill'))
        ];

    }
}
