<?php

namespace App\Http\Controllers\Auth;

use App\Models\TempUser;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterUserController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $tempUser = TempUser::create([
            'name' => $request['name'],
            'city' => $request['city'],
            'email' => $request['email'],
            'email_verification_code' => md5(rand(0,6)), 
            'password' => Hash::make($request['password']),
        ]);

        if ($tempUser) {    
            
            Mail::to($tempUser['email'])->send(new VerifyEmail($tempUser));
            return response()->json(['data' => [
                'success' => true
            ]]);
        } else {
            return response()->json(['errors' => [
                'root' => 'Cannot create user.'
            ]]);
        }
    }
}
