<?php

namespace App\Actions\Metal;

use App\Http\Resources\Characteristic\CharacteristicResource;
use App\Http\Resources\Metal\MetalResource;

class MetalShowAction
{
    /**
     * @return array
     */
    public function handle($metal): array
    {
        $characteristics = CharacteristicResource::collection($metal->characteristics->sortBy('title', SORT_NATURAL))->resolve();
        $metal = new MetalResource($metal);

        return compact(['characteristics', 'metal']);
    }
}
