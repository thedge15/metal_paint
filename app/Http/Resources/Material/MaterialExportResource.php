<?php

namespace App\Http\Resources\Material;

use App\Models\Project;
use App\Models\Standard;
use App\Models\Steel;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialExportResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $standard = Standard::query()->find($this->standard_id)->title;
        $steel = Steel::query()->find($this->steel_id)->title;
        return [
            'numb' => $this->numb,
            'project' => Project::query()->find($this->project_id)->title,
            'element' => $this->element,
            'title' => $this->title. ' ' . $standard . ' ' . $steel,
            'weight' => $this->weight,
            'units' => 'т',
            'paint' => $this->paint,
            'paint_quantity' => $this->paint_quantity,
            'paint_color' => $this->paint_color,
        ];
    }
}
