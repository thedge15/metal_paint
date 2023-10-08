<?php

namespace App\Http\Controllers;

use App\Actions\Steel\SteelIndexAction;
use App\Actions\Steel\SteelStoreAction;
use App\Actions\Steel\SteelUpdateAction;
use App\Models\Steel;
use Inertia\Response;
use Inertia\ResponseFactory;

class SteelController extends Controller
{

    /**
     * @param SteelIndexAction $action
     * @return Response|ResponseFactory
     */
    public function index(SteelIndexAction $action): Response|ResponseFactory
    {
        return inertia('Steel/Index', $action->handle());
    }

    /**
     * @param SteelStoreAction $action
     * @return void
     */
    public function store(SteelStoreAction $action): void
    {
        Steel::query()->create($action->handle());
    }

    /**
     * @param SteelUpdateAction $action
     * @param Steel $steel
     * @return void
     */
    public function update(SteelUpdateAction $action, Steel $steel): void
    {
        $steel->update($action->handle());
    }

    /**
     * @param Steel $steel
     * @return void
     */
    public function destroy(Steel $steel): void
    {
        $steel->delete();
    }
}
