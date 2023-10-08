<?php

namespace App\Actions\Paint;

use App\Http\Resources\Paint\PaintResource;
use App\Models\Paint;

class PaintIndexAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $paints = PaintResource::collection(Paint::all())->resolve();
        return compact('paints');
    }
}
