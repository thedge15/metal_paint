<?php

namespace App\Actions\Metal;

use App\Actions\StoreUpdateAction;
use Illuminate\Http\Request;

class MetalUpdateAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->getRequest()->validate([
            'title' => 'required|string',
        ]);
    }
}
