<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\BranchResource;
use Symfony\Component\HttpFoundation\Response;

class BranchesController extends Controller
{
    public function index(Request $request) 
    {
        // Return not Paginated Object
        if($request->input('all-branches') == 'true') {
            $branches = Branch::orderBy('name', 'asc')
                ->get()
                ->collect();
            return BranchResource::collection($branches)->response();
        } else {
        // Return Paginated Object
            $page = $request->input('page');

            $branches = Branch::orderBy('name', 'asc')->paginate(10, ['*'], 'page', $page);
        }

        if($branches) {
            return BranchResource::collection($branches)->response();
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'No branches found.'
                ]
            ]]);
        }


        // Eager + Lazy Loading 
        // $branches = Branch::with(['messages']);
        // return BranchResource::collection($branches->paginate(10))->response();
    }

    public function store(Branch $branch, Request $request) 
    {
        $this->authorize('create', $branch);

            $branch->create($this->validateRequest());

            return response()
                ->json(['data' => ['success' => true ]])
                ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Branch $branch, Request $request) 
    {
        $this->authorize('view', $branch);

        $branch = Branch::where('id',$request->id)->paginate();

        if($branch) {
            return response()->json(['data' => $branch]);
            // return BranchResource::collection($branch)->response();
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'No branch found.'
                ]
            ]]);
        }
    }

    public function update(Branch $branch, Request $request) 
    {
        $this->authorize('update', $branch);

        $branch = Branch::where('id', intval($request->id))->first();

        if($branch) {

            $branch->update($this->validateRequest());

            return response()->json(['data' => [
                'success' => 'Údaje boli úspešne upravené.'
            ]]);
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'No branch found.'
                ]
            ]]);
        }
    }

    public function destroy(Branch $branch, Request $request)
    {
        $this->authorize('delete', $branch);

        $branch = Branch::find($request->id);

        if($branch) {
            $branch->messages()->delete();
            $branch->users()->delete();
            $branch->delete();
        }
    }

    private function validateRequest()
    {
       return request()->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'regex:/^[+]*[0-9]{9,14}/', 'min:9', 'max:14'],
            'city' => ['required', 'string', 'max:80'],
            'address' => ['required', 'string', 'max:150'],
            'postal_code' => ['required', 'string', 'min:5', 'max:7'],
            'ico' => ['required', 'regex:/^[SK]*[0-9]{9,14}/', 'min:9', 'max:14']
        ]);
    }
}
