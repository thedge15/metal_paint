<?php

namespace App\Actions\Material;

use App\Actions\StoreUpdateAction;
use App\Models\Characteristic;
use App\Models\Material;
use App\Models\Paint;
class UpdateMaterialAction extends StoreUpdateAction
{
    public function handle(): array
    {
        $data = $this->getRequest()->validate([
            'id' => 'required|integer',
            'numb' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'paint' => 'nullable|string',
            'number_of_layers' => 'nullable|integer',
            'paint_color' => 'nullable|string',
            'is_pile' => 'nullable|boolean',
        ], ['numb.integer' => 'Число!',
            ]);

//        dd($data);

        $paint = Paint::query()->where('title', $data['paint'])->get()->toArray();

        $material = Material::query()->find($data['id']);

        $characteristic = Characteristic::query()->find($material['characteristic_id']);

        $data['length'] = $data['weight'] * $characteristic['ton_length'];
        $data['area'] = $data['weight'] * $characteristic['ton_area'];

        if ($data['paint'] && $data['number_of_layers']) {
            $data['paint_quantity'] = $paint[0]['consumption'] * $data['number_of_layers'] * $data['area'];
        } else if (!$data['paint'] && !$data['number_of_layers']) {
            unset($data['paint']);
        }

        if ($data['is_pile']) {
            $data['paint_quantity'] *= 0.483;
        }

        return $data;
    }
}
