<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\BranchResource;

class BranchesController extends Controller
{
    public function index(Request $request) 
    {
        $page = $request->input('page');

        $branches = Branch::select('*')
            ->orderBy('name', 'asc')
            ->paginate(10, ['*'], 'page', $page);
        // $branches = Branch::orderBy('name', 'asc')->paginate(10, ['*'], 'page', $page);

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

    public function show(Branch $branch, Request $request) 
    {
        $this->authorize('view', $branch);

        $branch = Branch::where('id',$request->id)->paginate();

        if($branch) {
            // return response()->json(['data' => $branch]);
            return BranchResource::collection($branch)->response();
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
}
