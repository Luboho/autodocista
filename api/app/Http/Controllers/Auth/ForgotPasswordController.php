<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\ForgotPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    public function forgotten() 
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'exists:App\Models\User,id' ],
        ]);

        $forgotUser = User::find($request->id);

        // Updated unique password to DB
        $forgotUser->password = md5(rand(0, 6));
        $forgotUser->save();

        // Verify User By Email
        if ($forgotUser) {    
            
            Mail::to($forgotUser['email'])->send(new ForgotPasswordMail($forgotUser));
            return response()->json(['data' => [
                'success' => true
            ]]);
        } else {
            return response()->json(['errors' => [
                'root' => 'Cannot send updated password to user mail.'
            ]]);
        }

    }
}
