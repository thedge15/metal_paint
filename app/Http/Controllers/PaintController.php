<?php

namespace App\Http\Controllers;

use App\Actions\Paint\PaintIndexAction;
use App\Actions\Paint\PaintStoreAction;
use App\Actions\Paint\PaintUpdateAction;
use App\Models\Paint;
use Inertia\Response;
use Inertia\ResponseFactory;

class PaintController extends Controller
{
    /**
     * @param PaintIndexAction $action
     * @return Response|ResponseFactory
     */
    public function index(PaintIndexAction $action): Response|ResponseFactory
    {
        return inertia('Paint/Index', $action->handle());
    }

    /**
     * @param PaintStoreAction $action
     * @return void
     */
    public function store(PaintStoreAction $action): void
    {
        Paint::query()->create($action->handle());
    }

    /**
     * @param Paint $paint
     * @param PaintUpdateAction $action
     * @return void
     */
    public function update(Paint $paint, PaintUpdateAction $action): void
    {
        $paint->update($action->handle());
    }

    /**
     * @param Paint $paint
     * @return void
     */
    public function destroy(Paint $paint): void
    {
        $paint->delete();
    }
}
