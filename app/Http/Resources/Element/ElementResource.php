<?php

namespace App\Http\Resources\Element;

use App\Http\Resources\Project\ProjectResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ElementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'project' => new ProjectResource($this->project),
            'title' => $this->title,
            'quantity' => $this->quantity,
        ];
    }
}
