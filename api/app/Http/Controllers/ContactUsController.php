<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Mail\MessageMail;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ContactUsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['nullable','string', 'max:50'],
            'email' => ['nullable','email'],
            'phone' => ['nullable', 'regex:/^[+]*[0-9]{9,13}/', 'min:9', 'max:13'],
            'branch_address' => ['required', 'string', 'exists:App\Models\Branch,address'],
            'message' => ['required', 'string', 'max:255']
        ]);

        $message = ContactUs::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'branch' => $request['branch_address'],
            'message' => $request['message']
        ]);

        // Get Branch Email 
        $branchEmail = Branch::where('address', $request['branch_address'])->first();

        // Send an Email to Appropriate Branch Receiver
        if ($message) {    
            
            Mail::to($branchEmail)->send(new MessageMail($message));
            return response()
                    ->json(['data' => ['success' => true ]])
                    ->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['errors' => [
                'root' => 'Cannot save message.'
            ]]);
        }
    }
}
