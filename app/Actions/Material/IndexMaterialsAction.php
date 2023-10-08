<?php

namespace App\Actions\Material;

use App\Http\Resources\Characteristic\CharacteristicResource;
use App\Http\Resources\Element\ElementResource;
use App\Http\Resources\Material\MaterialResource;
use App\Http\Resources\Metal\MetalResource;
use App\Http\Resources\Paint\PaintResource;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Standard\StandardResource;
use App\Http\Resources\Steel\SteelResource;
use App\Models\Characteristic;
use App\Models\Element;
use App\Models\Metal;
use App\Models\Paint;
use App\Models\Standard;
use App\Models\Steel;

class IndexMaterialsAction
{
    /**
     * @param $project
     * @return array
     */
    public function handle($project): array
    {

        $elements = ElementResource::collection(Element::all()->sortBy('title'))->resolve();
        $materials = MaterialResource::collection($project->materials)->resolve();
        $project = ProjectResource::make($project)->resolve();
        $metals = MetalResource::collection(Metal::all()->sortBy('title'))->resolve();
        $characteristics = CharacteristicResource::collection(Characteristic::all()->sortBy('title', SORT_NATURAL))->resolve();
        $standards = StandardResource::collection(Standard::all()->sortBy('title'))->resolve();
        $steels = SteelResource::collection(Steel::all()->sortBy('title'))->resolve();
        $units = ['т', 'м', 'шт.', 'м2'];
        $paints = PaintResource::collection(Paint::all()->sortBy('title'))->resolve();

        $colors = collect([
            'RAL 7004' => 'bg-gray-400',
            'RAL 1021' => 'bg-yellow-500',
            'RAL 5015' => 'bg-sky-400',
            'RAL 8002' => 'bg-amber-800',
        ]);

        return compact([
            'materials', 'project', 'metals', 'characteristics', 'standards', 'units', 'steels', 'elements', 'paints', 'colors']);
    }
}
