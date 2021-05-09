<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function index(Request $request, User $user, Branch $branch)
    {
        $page = $request->input('page');
        
        if(auth()->check() && auth()->user()->is_admin == '1') {
            $users = User::orderBy('branch_id', 'asc')->paginate(10, ['*'], 'page', $page);
        } 

        if($users) {
            return UserResource::collection($users)->response();
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'No users found.'
                ]
            ]]);
        }
    }

    public function destroy(User $user, Request $request)
    {
        $this->authorize('delete', $user);

        $user = User::find($request->id);

        if($user) {
            $user->delete();
        }
    }
}
