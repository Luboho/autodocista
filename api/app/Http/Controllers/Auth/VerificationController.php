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
    public function verify(Request $request, User $user)
    {
        $request->validate([
            'id' => 'required',
            'token' => 'required'
        ]);

        $tempUser = TempUser::find($request->id);
        $isAlreadyVerified = User::find($request->id);

        if ($tempUser && $request->token == $tempUser->email_verification_code) {
            $tempUser->email_verification_code = md5(rand(0, 6)); // Change verif.code to make it on once use.
            $tempUser->save();
            
            $userName = $tempUser->name;
            $branchId = $tempUser->branch_id;
            $userEmail = $tempUser->email;
            $userPhone = $tempUser->phone;
            $userIsAdmin = $tempUser->is_admin;
            // $userRole = $tempUser->role;
            $userEmailVerifCode = $tempUser->email_verification_code;
            $userPassword = $tempUser->password;


            // Find Appropriate Branch to Save New User into It.
            // $branch = Branch::find($branchId);
        }


        // Move Temporary User to Verified User table.
        if($tempUser) {
            $user = new User();
            $user->name = $userName;
            $user->branch_id = $branchId;
            $user->email = $userEmail;
            $user->phone = $userPhone;
            $user->is_admin = $userIsAdmin;
            // $user->role = $userRole;
            $user->email_verification_code = $userEmailVerifCode;
            $user->email_verified_at = now();
            $user->password = $userPassword;
            $user->save();

            // Delete Temp User Row
            $tempUser->delete();

            return response()
                    ->json(['data' => [ 'success' => 'Email bol úspešne overený. Prosím prihláste sa.' ]])
                    ->setStatusCode(Response::HTTP_CREATED);
        } elseif($isAlreadyVerified){
            return response()->json(['data' => [
                'warning' => 'Email už je overený. Prosím prihláste sa.'
            ]]);
        } else {
            return response()->json(['data' => [
                'error' => 'Pravdepodobne email nebol správne overený. Prosím požiadajte o nový verifikačný email.'
            ]]);
        }
    }
}
