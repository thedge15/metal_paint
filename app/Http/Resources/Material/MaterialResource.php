<?php

namespace App\Http\Resources\Material;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            'element' => $this->element,
            'numb' => $this->numb,
            'title' => $this->title,
            'weight' => $this->weight,
            'length' => $this->length,
            'area' => $this->area,
            'quantity' => $this->quantity,
            'paint' => $this->paint,
            'paint_quantity' => $this->paint_quantity,
            'paint_color' => $this->paint_color,
            'number_of_layers' => $this->number_of_layers,
            'is_pile' => $this->is_pile,
        ];
    }
}
