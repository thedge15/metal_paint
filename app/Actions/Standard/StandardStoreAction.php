<?php

namespace App\Actions\Standard;

use App\Actions\StoreUpdateAction;
use App\Models\Metal;

class StandardStoreAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $data = $this->getRequest()->validate([
            'metal' => 'required|string',
            'title' => 'required|string',
        ]);

        $metal_id = Metal::query()->where('title', $data['metal'])->pluck('id')[0];
        $data['metal_id'] = $metal_id;

        unset($data['metal']);

        return $data;
    }
}
