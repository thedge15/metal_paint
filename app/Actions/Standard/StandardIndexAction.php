<?php

namespace App\Actions\Standard;

use App\Http\Resources\Metal\MetalResource;
use App\Http\Resources\Standard\StandardResource;
use App\Models\Metal;
use App\Models\Standard;

class StandardIndexAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $metals = MetalResource::collection(Metal::all())->resolve();
        $standards = StandardResource::collection(Standard::all())->resolve();
        return compact(['metals', 'standards']);
    }
}
