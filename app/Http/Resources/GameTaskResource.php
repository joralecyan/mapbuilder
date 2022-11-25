<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class GameTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->task->title,
            'type' => $this->task->type,
            'duration' => $this->task->duration,
            'direction' => $this->task->direction,
            'items' => ItemResource::collection($this->task->items),
            'figures' => FigureResource::collection($this->task->figures)
        ];
    }
}
