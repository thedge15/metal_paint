<?php

namespace App\Actions\Material;

use App\Actions\StoreUpdateAction;
use App\Actions\TYPE_NAME;
use App\Models\Characteristic;
use App\Models\Metal;

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
            'element' => 'nullable|string',
            'metal' => 'required|string',
            'title' => 'required|string',
            'metalLength' => 'nullable|numeric',
            'sheetHeight' => 'nullable|integer',
            'sheetWidth' => 'nullable|integer',
            'standard' => 'required|string',
            'steel' => 'required|string',
            'quantity' => 'required|numeric',
            'measure_units' => 'required|string',
        ],
        [
            'metal.required' => 'Заполните поле!',
            'title.required' => 'Заполните поле!',
            'standard.required' => 'Заполните поле!',
            'steel.required' => 'Заполните поле!',
            'quantity.required' => 'Заполните поле!',
            'measure_units.required' => 'Заполните поле!',
        ]);

        $metal = Metal::query()->where('title',$data['metal'])->get();
        $data['metal_id'] = $metal[0]->id;
        $characteristics = Characteristic::query()->where('metal_id', $data['metal_id'])->get();
        $data['characteristic_id'] = $characteristics->where('title', $data['title'])->pluck('id')->first();
        if ($data['sheetHeight'] && $data['sheetWidth']) {
            $thickness = $data['title'];
            $data['title'] = $data['title'] . 'X' . $data['sheetHeight'] . 'X' . $data['sheetWidth'];
        }

        if ($data['metal'] !== 'Лист') {

            $tonLength = $characteristics->where('title', $data['title'])->first()->ton_length;
            $tonArea = $characteristics->where('title', $data['title'])->first()->ton_area;

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
            if ($data['measure_units'] === 'т') {
                $tonArea = $characteristics->where('title', $data['title'])->first()->ton_area;
                $data['weight'] = $data['quantity'];
                $data['area'] = $tonArea * $data['weight'];
            } elseif ($data['measure_units'] === 'шт.') {
                $tonArea = $characteristics->where('title', $thickness)->first()->ton_area;
                $data['area'] = 2 * ($data['sheetHeight'] / 1000) * ($data['sheetWidth'] / 1000) * $data['quantity'];
                $data['weight'] = $data['area'] / $tonArea;
            }
        }

        if ($data['metalLength']) {
            $data['title'] = $data['title'] . ' L=' . $data['metalLength'];
        }
        $data['title'] = $data['metal'] . ' ' . $data['title'] . ' ' . $data['standard'] . ' ' . $data['steel'];

        unset($data['metal'], $data['standard']);

        if ($data['measure_units'] !== 'шт.') {
            unset($data['quantity']);
        }

        unset($data['measure_units'], $data['steel'], $data['sheetHeight'], $data['sheetWidth'], $data['metalLength']);

        return $data;
    }
}
