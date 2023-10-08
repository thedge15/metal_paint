<?php

namespace App\Actions\Characteristic;

use App\Actions\StoreUpdateAction;

class CharacteristicUpdateAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->getRequest()->validate([
            'title' => 'nullable|string',
            'ton_length' => 'nullable|numeric',
            'ton_area' => 'nullable|numeric',
        ]);
    }
}
