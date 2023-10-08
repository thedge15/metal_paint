<?php

namespace App\Actions\Standard;

use App\Actions\StoreUpdateAction;

class StandardUpdateAction extends StoreUpdateAction
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
