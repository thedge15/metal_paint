<?php

namespace App\Http\Resources\Element;

use App\Http\Resources\Project\ProjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ElementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'project' => new ProjectResource($this->project),
            'title' => $this->title,
            'quantity' => $this->quantity,
        ];
    }
}
