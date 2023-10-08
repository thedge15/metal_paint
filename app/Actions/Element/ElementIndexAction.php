<?php

namespace App\Actions\Element;

use App\Http\Resources\Element\ElementResource;
use App\Models\Element;

class ElementIndexAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $elements = ElementResource::collection(Element::all()->sortBy('title'))->resolve();
        return compact('elements');
    }
}
