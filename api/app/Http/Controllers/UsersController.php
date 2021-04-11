<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function index(Request $request, User $user)
    {
        $users = User::get();

        if($users) {
            return UserResource::collection($users);
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'No users found.'
                ]
            ]]);
        }
    }
}
