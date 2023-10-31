<?php

namespace App\Actions\Bush;

use App\Http\Resources\Bush\BushResource;
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

class BushAllAction
{
    /**
     * @return array
     */
    public function handle($bush): array
    {
        $projects = $bush->projects;
        $projectsFilterCollection = collect($projects)->pluck('title');

        $materials = collect([]);

        foreach ($projects as $project) {
            foreach ($project->materials as $item) {
                $materials[] = MaterialResource::make($item)->resolve();
            }
        }

        $materialsFilter = collect($materials)->pluck('characteristic');
        $materialsFilterCollection = collect([]);

        foreach ($materialsFilter as $item) {
            $materialsFilterCollection[] = [Metal::query()->find($item['metal_id'])->title, $item['title']];
        }

        $materialsFilterCollection = $materialsFilterCollection->unique()->sort();

//        dd($materialsFilterCollection);

        $elementsFilter = collect($materials)->pluck('element')->unique()->sort();

        $elementsFilterCollection = [];
        foreach ($elementsFilter as $item) {
            $elementsFilterCollection[] = $item;
        }

        $paints = PaintResource::collection(Paint::all()->sortBy('title'))->resolve();

        $colors = collect([
            'RAL 7004' => 'bg-gray-400',
            'RAL 1021' => 'bg-yellow-500',
            'RAL 5015' => 'bg-sky-400',
            'RAL 8002' => 'bg-amber-800',
        ]);

//        dd($projects);

        $elements = ElementResource::collection(Element::all()->sortBy('title'))->resolve();
        $metals = MetalResource::collection(Metal::all()->sortBy('title'))->resolve();
        $characteristics = CharacteristicResource::collection(Characteristic::all()->sortBy('title', SORT_NATURAL))->resolve();
        $standards = StandardResource::collection(Standard::all()->sortBy('title'))->resolve();
        $steels = SteelResource::collection(Steel::all()->sortBy('title'))->resolve();
        $units = ['т', 'м', 'шт.', 'м2'];
        $projects=ProjectResource::collection($projects->sortBy('title'))->resolve();

        $bush = BushResource::make($bush)->resolve();
        return compact(['materials', 'metals', 'characteristics', 'bush', 'elements', 'paints', 'colors',
            'projects', 'units', 'standards', 'steels', 'materialsFilterCollection', 'elementsFilterCollection',
            'projectsFilterCollection']);
    }
}
