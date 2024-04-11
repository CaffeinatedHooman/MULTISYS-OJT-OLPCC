<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubtaskResource;

class TodoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'completed' => $this->completed ? 'yes' : 'no',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'subtasks' => SubtaskResource::collection($this->whenLoaded('subtasks')),
        ];
    }
}
