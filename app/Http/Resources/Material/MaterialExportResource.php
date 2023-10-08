<?php

namespace App\Http\Resources\Material;

use App\Models\Project;
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
        return [
            'numb' => $this->numb,
            'project' => Project::query()->find($this->project_id)->title,
            'element' => $this->element,
            'title' => $this->title,
            'weight' => $this->weight,
            'units' => 'т',
            'paint' => $this->paint,
            'paint_quantity' => $this->paint_quantity,
            'paint_color' => $this->paint_color,
        ];
    }
}
