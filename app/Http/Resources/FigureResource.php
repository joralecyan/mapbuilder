<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FigureResource extends JsonResource
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
            'figure' => $this->figure,
            'is_extra' => $this->is_extra
        ];
    }
}
