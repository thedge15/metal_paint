<?php

namespace App\Http\Controllers;

use App\Actions\Metal\MetalIndexAction;
use App\Actions\Metal\MetalShowAction;
use App\Actions\Metal\MetalStoreAction;
use App\Actions\Metal\MetalUpdateAction;
use App\Models\Metal;
use Inertia\Response;
use Inertia\ResponseFactory;

class MetalController extends Controller
{
    /**
     * @param MetalIndexAction $action
     * @return Response|ResponseFactory
     */
    public function index(MetalIndexAction $action): Response|ResponseFactory
    {
        return inertia('Metal/Index', $action->handle());
    }

    /**
     * @param MetalStoreAction $action
     * @return void
     */
    public function store(MetalStoreAction $action): void
    {
        Metal::query()->create($action->handle());
    }

    /**
     * @param Metal $metal
     * @param MetalShowAction $action
     * @return Response|ResponseFactory
     */
    public function show(Metal $metal, MetalShowAction $action): Response|ResponseFactory
    {
        return inertia('Metal/Show', $action->handle($metal));
    }

    /**
     * @param MetalUpdateAction $action
     * @param Metal $metal
     * @return void
     */
    public function update(MetalUpdateAction $action, Metal $metal): void
    {
        $metal->update($action->handle());
    }

    /**
     * @param Metal $metal
     * @return void
     */
    public function destroy(Metal $metal): void
    {
        $metal->delete();
    }
}
