<?php

namespace App\Actions\Element;

use App\Actions\StoreUpdateAction;
class ElementStoreAction extends StoreUpdateAction
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
