<?php

namespace App\Actions\Steel;

use App\Http\Resources\Steel\SteelResource;
use App\Models\Steel;

class SteelIndexAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $steels = SteelResource::collection(Steel::all())->resolve();
        return compact('steels');
    }
}
