<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\BranchResource;

class BranchesController extends Controller
{
    public function index(Request $request) {
        $branches = Branch::get();

        if($branches) {
            return BranchResource::collection($branches);
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'No branches found.'
                ]
            ]]);
        }
    }
}
