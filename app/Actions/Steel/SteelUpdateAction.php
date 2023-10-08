<?php

namespace App\Actions\Steel;
use App\Actions\StoreUpdateAction;

class SteelUpdateAction extends StoreUpdateAction
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
