<?php

namespace App\Http\Resources\Standard;

use App\Models\Metal;
use Illuminate\Http\Resources\Json\JsonResource;

class StandardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return [
            'id' => $this->id,
            'metal' => Metal::query()->find($this->metal_id)->title,
            'title' => $this->title,
        ];
    }
}
