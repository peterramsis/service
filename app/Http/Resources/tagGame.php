<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class tagGame extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "tag_name" => $this->tag_name ,
            
        ];
    }
}
