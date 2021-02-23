<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\TempUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'token' => 'required'
        ]);

        $tempUser = TempUser::find($request->id);

        if ($tempUser && $request->token == $tempUser->email_verification_code) {
            $tempUser->email_verification_code = md5(rand(0, 6));
            $tempUser->save();
            
            $userName = $tempUser->name;
            $userCity = $tempUser->city;
            $userEmail = $tempUser->email;
            $userEmailVerifCode = $tempUser->email_verification_code;
            $userPassword = $tempUser->password;
            
        }

        // Move Temporary User to Verified User table.
        if($tempUser) {
            $user = new User();
            $user->name = $userName;
            $user->city = $userCity;
            $user->email = $userEmail;
            $user->email_verification_code = $userEmailVerifCode;
            $user->email_verified_at = now();
            $user->password = $userPassword;
            $user->save();
            // Delete Temp User Row
            $tempUser->delete();

            return response()->json(['data' => [
                'success' => true
            ]]);
        } else {
            return response()->json(['data' => [
                'success' => false
            ]]);
        }
    }
}
