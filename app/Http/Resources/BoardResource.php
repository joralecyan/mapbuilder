<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoardResource extends JsonResource
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
            'id' => $this->id,
            'map' => $this->map,
            'user' => new UserResource($this->user),
            'points' => new BoardPointResource($this->points),
            'created_at' => $this->created_at,
            'updated_at' => $this->created_at,
        ];
    }
}
