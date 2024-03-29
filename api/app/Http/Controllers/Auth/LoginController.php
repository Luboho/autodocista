<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

        public function __invoke(Request $request) 
        {
            if (!auth()->attempt($this->validateData())) {
                throw new AuthenticationException();
            }
        }
    
        private function validateData()
        {
            return request()->validate([
                'email' => 'required|email',
                'password' => 'required|',
            ]);
        }
}
