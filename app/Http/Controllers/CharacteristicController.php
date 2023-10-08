<?php

namespace App\Http\Controllers;

use App\Actions\Characteristic\CharacteristicStoreAction;
use App\Actions\Characteristic\CharacteristicUpdateAction;
use App\Models\Characteristic;

class CharacteristicController extends Controller
{
    public function store(CharacteristicStoreAction $action)
    {
        Characteristic::query()->create($action->handle());
    }
    public function update(CharacteristicUpdateAction $action, Characteristic $characteristic)
    {
        $characteristic->update($action->handle());
    }
    public function destroy(Characteristic $characteristic)
    {
        $characteristic->delete();
    }
}
