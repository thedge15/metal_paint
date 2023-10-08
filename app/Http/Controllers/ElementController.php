<?php

namespace App\Http\Controllers;

use App\Actions\Element\ElementIndexAction;
use App\Actions\Element\ElementStoreAction;
use App\Actions\Element\ElementUpdateAction;
use App\Models\Element;
use Inertia\Response;
use Inertia\ResponseFactory;

class ElementController extends Controller
{
    /**
     * @param ElementIndexAction $action
     * @return Response|ResponseFactory
     */
    public function index(ElementIndexAction $action): Response|ResponseFactory
    {
        return inertia('Element/Index', $action->handle());
    }

    /**
     * @param ElementStoreAction $action
     * @return void
     */
    public function store(ElementStoreAction $action): void
    {
        Element::query()->create($action->handle());
    }

    /**
     * @param ElementUpdateAction $action
     * @param Element $element
     * @return void
     */
    public function update(ElementUpdateAction $action, Element $element): void
    {
        $element->update($action->handle());
    }

    /**
     * @param Element $element
     * @return void
     */
    public function delete(Element $element): void
    {
        $element->delete();
    }
}
