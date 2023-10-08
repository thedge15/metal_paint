<?php

namespace App\Actions\Bush;

use App\Http\Resources\Bush\BushResource;
use App\Http\Resources\User\UserResource;
use App\Models\Bush;
use App\Models\User;

class BushIndexAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $bushes = BushResource::collection(Bush::all()->sortBy('title'))->resolve();
        $user = new UserResource(User::query()->find(auth()->id()));
        return compact(['bushes', 'user']);
    }
}
