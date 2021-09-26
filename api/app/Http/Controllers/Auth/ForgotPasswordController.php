<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
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

    public function forgotPassword(Request $request) 
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'exists:App\Models\User,email' ],
        ]);

        $forgotUser = User::where('email', $request->email)->first();

        // Set New verif. code.
        $forgotUser->email_verification_code = md5(rand(0,6));
        $forgotUser->save();

        if ($forgotUser) {    
            
            Mail::to($forgotUser['email'])->send(new ForgotPasswordMail($forgotUser));
            return response()
                    ->json(['data' => [ 'success' => 'Na váš email bola odoslaná odkaz. Prosím potvrďte ho.' ]]);
        } else {
            return response()->json(['data' => [
                'error' => 'Ups, niečo sa pokazilo. Skúste prosím opakovať akciu neskôr.']])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

    }

    public function verifyForgot(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:App\Models\User,id'],
            'token' => ['required', 'exists:App\Models\User,email_verification_code']
        ]);

        $resetUserPassword = User::where('id', $request->id)->first();
        
        if ($resetUserPassword && $request->token == $resetUserPassword->email_verification_code) {

            $resetUserPassword->email_verified_at = now();
            $resetUserPassword->save();

            return response()
                ->json(['data' => [
                    'success' => 'Email overený. Prosím nastavte si nové heslo.',
                    'email' => $resetUserPassword->email
                    ]]);

        } else {
            return response()->json(['data' => [
                'error' => 'Ups, niečo sa pokazilo. Skúste prosím opakovať akciu neskôr.']])
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }  
    }
}
