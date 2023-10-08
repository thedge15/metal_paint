<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function welcome(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('Welcome');
    }

    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        $users = UserResource::collection(User::all())->resolve();
        return inertia('User/Users', compact('users'));
    }
}
