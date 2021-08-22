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

        $filterByCategoryArr = explode(",", $request->get('branch_id'));
        // If filter is active
        if($filterByCategoryArr[0] != ""){
            $filterByCategoryArr = $filterByCategoryArr;
        } else {
            $filterByCategoryArr = false;
        }

        $users = User::select('*')
            ->orderBy('name', 'asc')
            ->when($filterByCategoryArr, function($users, $filterByCategoryArr) {
                return $users->whereIn('branch_id', $filterByCategoryArr);
            })
            ->paginate(10, ['*'], 'page', $page);

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

    public function allUsers(Request $request) 
    {
        // Provided that All Users Can See Each Other, even Users Can See Admins
        if(auth()->check()) {
            $users = User::all();
        }

        if($users) {
            return UserResource::collection($users)->response();
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'No Users.'
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
