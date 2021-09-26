<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'max_count' => $this->max_count,
            'boards_count' => $this->boards_count,
            'boards' => BoardResource::collection($this->whenLoaded('boards')),
            'missions' => GameMissionResource::collection($this->whenLoaded('missions')),
            'season' => new SeasonResource($this->whenLoaded('season')),
            'created_at' => $this->created_at
        ];
    }
}
