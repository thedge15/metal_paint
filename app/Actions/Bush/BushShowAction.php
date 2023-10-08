<?php

namespace App\Actions\Bush;

use App\Http\Resources\Bush\BushResource;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class BushShowAction
{
    /**
     * @return array
     */
    public function handle($bush): array
    {
        $projects = ProjectResource::collection($bush->projects)->resolve();
        $bush = BushResource::make($bush)->resolve();
        $user = new UserResource(User::query()->find(auth()->id()));
        return compact(['projects', 'bush', 'user']);
    }
}
