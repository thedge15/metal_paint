<?php

namespace App\Http\Resources\Material;

use App\Http\Resources\Characteristic\CharacteristicResource;
use App\Http\Resources\Element\ElementResource;
use App\Http\Resources\Metal\MetalResource;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Standard\StandardResource;
use App\Http\Resources\Steel\SteelResource;
use App\Models\Characteristic;
use App\Models\Element;
use App\Models\Metal;
use App\Models\Project;
use App\Models\Standard;
use App\Models\Steel;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'element' => ElementResource::make(Element::query()->findOrFail($this->element_id))->resolve(),
            'numb' => $this->numb,

            'project' => $this->project_id ? ProjectResource::make(Project::query()->findOrFail($this->project_id))->resolve() : null,
            'metal' => MetalResource::make(Metal::query()->findOrFail($this->metal_id))->resolve(),
            'characteristic' => CharacteristicResource::make(Characteristic::query()->findOrFail($this->characteristic_id))->resolve(),
            'standard' => StandardResource::make(Standard::query()->findOrFail($this->standard_id))->resolve(),
            'steel' => SteelResource::make(Steel::query()->findOrFail($this->steel_id))->resolve(),
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
