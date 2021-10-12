<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

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
            return response()
                ->json(['data' => ['error' => 'Užívateľ sa nenašiel']])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(User $user, Request $request) {
        $this->authorize('update', $user);

        $updateUser = User::where('id', intval($request->id))->first();

        if($updateUser) {

            $validated = request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'min:9', ],
                'branch_id' => ['required', 'exists:App\Models\Branch,id'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            User::where('id', $updateUser->id)->update(array(
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'branch_id' => $validated['branch_id'],
                'password' => Hash::make($validated['password'])
            ));

            return response()->json(['data' => [
                'success' => 'Údaje boli úspešne upravené.'
            ]]);
        } else {
            return response()
                ->json(['data' => ['error' => 'Ups, niečo sa pokazilo. Skúste opakovať požiadavku znova.']])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
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
            return response()
                ->json(['data' => ['error' => 'Žiaden užívateľ']])
                ->setStatusCode(Response::NO_CONTENT);
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

    private function validateRequest()
    {
       return request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:9', ],
            'is_admin' => ['required', 'boolean'],
            'branch_id' => ['required', 'exists:App\Models\Branch,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
