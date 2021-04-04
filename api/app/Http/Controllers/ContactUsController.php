<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use App\Models\ContactFormMessage;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\ContactUsResource;
use Symfony\Component\HttpFoundation\Response;

class ContactUsController extends Controller
{
    public function store(Request $request, Branch $branch)
    {
        $data = request()->validate([
            'name' => ['nullable','string', 'max:50'],
            'email' => ['nullable','email'],
            'phone' => ['nullable', 'regex:/^[+]*[0-9]{9,13}/', 'min:9', 'max:13'],
            'message' => ['required', 'string', 'max:255'],
            'branch_id' => ['required', 'exists:App\Models\Branch,id'],
        ]);

        // Get Branch object marked by User.
        $branch = Branch::where('id', $request['branch_id'])->first();

        $message = $branch->messages()->create($data);

        // Send an Email to Appropriate Branch Receiver
        if ($message) {    
            
            Mail::to($branch->email)->send(new MessageMail($message));
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
