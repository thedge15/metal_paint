<?php

namespace App\Http\Controllers;

use App\Actions\Material\IndexMaterialsAction;
use App\Actions\Material\StoreMaterialAction;
use App\Actions\Material\UpdateMaterialAction;
use App\Actions\ShowAllAction;
use App\Exports\MaterialsExport;
use App\Models\Material;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
/**
 *
 */
class MaterialController extends Controller
{
    /**
     * @param Project $project
     * @param IndexMaterialsAction $action
     * @return Response|ResponseFactory
     */
    public function index(Project $project, IndexMaterialsAction $action): Response|ResponseFactory
    {
        return inertia('Material/Index', $action->handle($project));
    }

    /**
     * @param StoreMaterialAction $action
     * @return RedirectResponse
     */
    public function store(StoreMaterialAction $action): RedirectResponse
    {
        Material::query()->create($action->handle());
        return redirect()->back();
    }
    /**
     * @param UpdateMaterialAction $action
     * @param Material $material
     * @return void
     */
    public function update(UpdateMaterialAction $action, Material $material): void
    {
        $material->update($action->handle());
    }
    /**
     * @param Material $material
     * @return void
     */
    public function destroy(Material $material): void
    {
        $material->delete();
    }
    /**
     * @param ShowAllAction $action
     * @return Response|ResponseFactory
     */
    public function showAll(ShowAllAction $action): Response|ResponseFactory
    {
        return inertia('Material/All', $action->handle());
    }
    /**
     * @param Project $project
     * @return BinaryFileResponse
     */
    public function export(Project $project): BinaryFileResponse
    {
        return Excel::download(new MaterialsExport($project), $project->title . '.xlsx');
    }
}

