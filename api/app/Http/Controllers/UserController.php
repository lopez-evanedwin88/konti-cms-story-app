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
        if (auth()->user()) {
            $users = User::all();
            return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
        }
    }

    public function userStores(Request $request): JsonResponse 
    {
        $input = $request->all();
        $users = $input['users_id'];
        
        if (auth()->user()) {
            $usersObj = User::whereIn('id', $users)->get();
            return $this->sendResponse(UserResource::collection($usersObj), 'Users retrieved successfully.');
        }
    }
}
