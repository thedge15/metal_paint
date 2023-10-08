<?php

namespace App\Http\Controllers;

use App\Actions\Project\ProjectStoreAction;
use App\Actions\Project\ProjectUpdateAction;
use App\Models\Project;

class ProjectController extends Controller
{
    public function store(ProjectStoreAction $action)
    {
        Project::query()->create($action->handle());
    }
    public function update(ProjectUpdateAction $action, Project $project)
    {
        $project->update($action->handle());
    }
    public function destroy(Project $project)
    {
        $project->materials()->delete();
        $project->delete();
    }
}
