<?php

namespace App\Actions\Metal;

use App\Http\Resources\Metal\MetalResource;
use App\Models\Metal;

class MetalIndexAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $metals = MetalResource::collection(Metal::all()->sortBy('title'))->resolve();
        return compact('metals');
    }
}
