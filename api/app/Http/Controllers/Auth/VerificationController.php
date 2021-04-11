<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Branch;
use App\Models\TempUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Symfony\Component\HttpFoundation\Response;

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
            $tempUser->email_verification_code = md5(rand(0, 6)); // Change verif.code to make it on once use.
            $tempUser->save();
            
            $userName = $tempUser->name;
            $branchId = $tempUser->branch_id;
            $userEmail = $tempUser->email;
            $userPhone = $tempUser->phone;
            $userRole = $tempUser->role;
            $userEmailVerifCode = $tempUser->email_verification_code;
            $userPassword = $tempUser->password;


            // Find Appropriate Branch to Save New User to It.
            // $branch = Branch::find($branchId);
        }


        // Move Temporary User to Verified User table.
        if($tempUser) {
            $user = new User();
            $user->name = $userName;
            $user->branch_id = $branchId;
            $user->email = $userEmail;
            $user->phone = $userPhone;
            $user->role = $userRole;
            $user->email_verification_code = $userEmailVerifCode;
            $user->email_verified_at = now();
            $user->password = $userPassword;
            $user->save();

            // Delete Temp User Row
            $tempUser->delete();



            return response()
                    ->json(['data' => [ 'success' => true ]])
                    ->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['data' => [
                'success' => false
            ]]);
        }
    }
}
