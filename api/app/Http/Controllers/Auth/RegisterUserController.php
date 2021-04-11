<?php

namespace App\Http\Controllers\Auth;

use App\Models\TempUser;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:9', ],
            'branch_id' => ['required', 'exists:App\Models\Branch,id'],
            'role' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $tempUser = TempUser::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'email_verification_code' => md5(rand(0,6)), 
            'role' => $request['role'],
            'password' => Hash::make($request['password']),
            'branch_id' => $request['branch_id'],
        ]);

        if ($tempUser) {    
            
            Mail::to($tempUser['email'])->send(new VerifyEmail($tempUser));
            return response()
                    ->json(['data' => ['success' => true ]])
                    ->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['errors' => [
                'root' => 'Cannot create user.'
            ]]);
        }
    }
}
