<?php

namespace App\Actions\Material;

use App\Actions\StoreUpdateAction;
use App\Actions\TYPE_NAME;
use App\Models\Characteristic;

/**
 *
 */
class StoreMaterialAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        /** @var TYPE_NAME $weight */
        /** @var TYPE_NAME $length */
        /** @var TYPE_NAME $thickness */

        $data = $this->getRequest()->validate([
            'project_id' => 'required|integer',
            'numb' => 'nullable|integer',
            'element_id' => 'nullable|integer',
            'metal_id' => 'required|integer',
            'characteristic_id' => 'required|integer',
            'metalLength' => 'nullable|numeric',
            'sheetHeight' => 'nullable|integer',
            'sheetWidth' => 'nullable|integer',
            'standard_id' => 'required|integer',
            'steel_id' => 'required|integer',
            'quantity' => 'required|numeric',
            'measure_units' => 'required|string',
        ],
            [
                'metal_id.required' => 'Заполните поле!',
                'standard_id.required' => 'Заполните поле!',
                'steel_id.required' => 'Заполните поле!',
                'quantity.required' => 'Заполните поле!',
                'measure_units.required' => 'Заполните поле!',
            ]);

        $characteristics = Characteristic::query()->find($data['characteristic_id']);

        if ($data['metal_id'] !== 3) {

            $tonLength = $characteristics->ton_length;
            $tonArea = $characteristics->ton_area;

            if ($data['measure_units'] === 'т') {
                $data['weight'] = $data['quantity'];
                $data['length'] = $data['weight'] * $tonLength;
            } elseif ($data['measure_units'] === 'м') {
                $data['length'] = $data['quantity'];
                $data['weight'] = $data['length'] / (float)$tonLength;
            } elseif ($data['measure_units'] === 'шт.' && $data['metalLength']) {
                $data['length'] = $data['metalLength'] * $data['quantity'] / 1000;
                $data['weight'] = $data['length'] / (float)$tonLength;
            }

            $data['area'] = $data['weight'] * $tonArea;

        } else {
            $tonArea = $characteristics->ton_area;
            if ($data['measure_units'] === 'т') {
                $data['weight'] = $data['quantity'];
                $data['area'] = $tonArea * $data['weight'];
            } elseif ($data['measure_units'] === 'шт.') {
                $data['area'] = 2 * ($data['sheetHeight'] / 1000) * ($data['sheetWidth'] / 1000) * $data['quantity'];
                $data['weight'] = $data['area'] / $tonArea;
            }
        }

        unset($data['measure_units'], $data['sheetHeight'], $data['sheetWidth'], $data['metalLength'], $data['quantity']);

        return $data;
    }
}
