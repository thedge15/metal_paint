<?php

namespace App\Actions\Paint;
use App\Actions\StoreUpdateAction;

class PaintStoreAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->getRequest()->validate([
            'title' => 'required|string',
            'consumption' => 'required|numeric',
        ]);
    }
}
