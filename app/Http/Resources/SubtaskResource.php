<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SubtaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'completed' => $this->completed ? 'yes' : 'no',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
