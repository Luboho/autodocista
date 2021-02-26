<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;

    // /**
    //  * Where to redirect users after resetting their password.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function resetPassword(Request $request) 
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $newUserPassword = User::where('email', $request->email)->first();

        if($newUserPassword) {
            $newUserPassword->password = Hash::make($request['password']);
            $newUserPassword->save();

            return response()
                    ->json(['data' => ['success' => true ]])
                    ->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['error' => [
                'root' => 'Something wrong, password not been changed.'
            ]]);
        }
    }
}
