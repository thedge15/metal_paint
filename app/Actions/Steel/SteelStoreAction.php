<?php

namespace App\Actions\Steel;

use App\Actions\StoreUpdateAction;

class SteelStoreAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $data = $this->getRequest()->validate([
                'title' => 'required|string',
                'steel_standard' => 'required|string',
            ]);
        $data['title'] = $data['title'] . ' ГОСТ ' . $data['steel_standard'];
        unset($data['steel_standard']);

        return $data;
    }
}
