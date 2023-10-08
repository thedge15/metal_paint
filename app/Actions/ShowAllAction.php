<?php

namespace App\Actions;

use App\Models\Bush;
use App\Models\Characteristic;
use App\Models\Element;
use App\Models\Material;
use App\Models\Metal;
use App\Models\Paint;
use App\Models\Project;
use App\Models\Standard;
use App\Models\Steel;
use App\Models\Unit;

class ShowAllAction
{
    public function handle()
    {
        $materials = Material::all();
        $bushes = Bush::all();
        $characteristics = Characteristic::all();
        $projects = Project::all();
        $metals = Metal::all();
        $standards = Standard::all();
        $steels = Steel::all();
        $elements = Element::all();
        $paints = Paint::all();

        return compact(['materials', 'bushes', 'characteristics', 'metals', 'projects', 'standards', 'steels',
            'elements', 'paints']);
    }
}
