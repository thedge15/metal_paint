<?php

namespace App\Http\Resources\Characteristic;

use App\Http\Resources\Metal\MetalResource;
use App\Models\Characteristic;
use App\Models\Metal;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacteristicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'metal' => new MetalResource($this->metal),
            'title' => $this->title,
            'ton_length' => $this->ton_length,
            'ton_area' => $this->ton_area,
        ];
    }
}
