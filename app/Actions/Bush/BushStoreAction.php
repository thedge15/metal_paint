<?php

namespace App\Actions\Bush;

use App\Actions\StoreUpdateAction;
class BushStoreAction extends StoreUpdateAction
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
