<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

use App\Models\User;

class UserController extends BaseController
{
    //
    public function index(): JsonResponse
    {
        $user = auth()->user();

        if ($user) {
            $users = User::all();
            return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
        }
    }
}
