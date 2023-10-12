<?php

namespace App\Actions\Bush;

use App\Http\Resources\Bush\BushResource;
use App\Http\Resources\Material\MaterialResource;
use App\Http\Resources\Paint\PaintResource;
use App\Models\Paint;

class BushAllAction
{
    /**
     * @return array
     */
    public function handle($bush): array
    {
        $projects = $bush->projects;
        $materials = [];

        foreach ($projects as $project) {
            foreach ($project->materials as $item) {
                $materials[] = MaterialResource::make($item)->resolve();
            }
        }

        $materialsFilter = collect($materials)->pluck('title')->unique()->sortBy('title');

        $materialsFilterCollection = [];

        foreach ($materialsFilter as $item) {
            $materialsFilterCollection[] = $item;
        }

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

        $bush = BushResource::make($bush)->resolve();
        return compact(['materials', 'bush', 'paints', 'colors', 'materialsFilterCollection', 'elementsFilterCollection']);
    }
}
