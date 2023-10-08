<?php

namespace App\Actions\Metal;

use App\Actions\StoreUpdateAction;

class MetalStoreAction extends StoreUpdateAction
{

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->getRequest()->validate([
            'title' => 'required|string'
        ]);
    }
}
