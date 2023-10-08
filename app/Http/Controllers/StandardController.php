<?php

namespace App\Http\Controllers;

use App\Actions\Standard\StandardIndexAction;
use App\Actions\Standard\StandardStoreAction;
use App\Actions\Standard\StandardUpdateAction;
use App\Models\Standard;
use Inertia\Response;
use Inertia\ResponseFactory;

class StandardController extends Controller
{
    /**
     * @param StandardIndexAction $action
     * @return Response|ResponseFactory
     */
    public function index(StandardIndexAction $action): Response|ResponseFactory
    {
        return inertia('Standard/Index', $action->handle());
    }

    /**
     * @param StandardStoreAction $action
     * @return void
     */
    public function store(StandardStoreAction $action): void
    {
        Standard::query()->create($action->handle());
    }

    /**
     * @param StandardUpdateAction $action
     * @param Standard $standard
     * @return void
     */
    public function update(StandardUpdateAction $action, Standard $standard): void
    {
        $standard->update($action->handle());
    }

    /**
     * @param Standard $standard
     * @return void
     */
    public function destroy(Standard $standard): void
    {
        $standard->delete();
    }
}
