<?php

namespace App\Actions\Characteristic;

use App\Actions\StoreUpdateAction;
use App\Models\Metal;

class CharacteristicStoreAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $data = $this->getRequest()->validate([
            'metal_id' => 'required|integer',
            'title' => 'nullable|string',
            'diameter' => 'nullable|numeric',
            'size' => 'nullable|integer',
            'second_size' => 'nullable|integer',
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
            'wall' => 'nullable|integer',
            'thickness' => 'nullable|integer',
            'sheet_width' => 'nullable|integer',
            'sheet_height' => 'nullable|integer',
            'ton_length' => 'nullable|numeric',
            'ton_area' => 'required|numeric',
        ]);

        $metal = Metal::query()->find($data['metal_id'])->title;

//      для уголка
        if ($metal === 'Уголок') {
            $data['title'] = is_null($data["second_size"]) ? $data["size"] . 'X' . $data['wall'] : $data["size"] . 'X' . $data["second_size"] . 'X' . $data['wall'];
        };

//      для трубы
        if ($metal === 'Труба') {
            $data['title'] = $data["diameter"] . 'X' . $data['wall'];
        };

//      для листа
        if ($metal === 'Лист' || $metal === 'Лист рулонный') {
            $data['title'] = $data['thickness'];
        };

//      для квадратной трубы
        if ($metal === 'Труба квадратная') {
            $data['title'] = $data['width'] . 'X' . $data['height'] . 'X' . $data['wall'];
        };

//      для круга
        if ($metal === 'Круг') {
            $data['title'] = $data["diameter"];
        };

        unset($data['mark'], $data["diameter"], $data["size"], $data["second_size"], $data['wall'], $data['thickness'], $data['width'], $data['height']);

        return $data;
    }
}
