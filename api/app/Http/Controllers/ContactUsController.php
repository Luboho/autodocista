<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use App\Models\ContactFormMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use App\Http\Resources\ContactUsResource;
use Symfony\Component\HttpFoundation\Response;

class ContactUsController extends Controller
{
    public function index(Request $request, ContactFormMessage $contactFormMessage)
    {
        if(auth()->check() && auth()->user()->role == 'admin') {
            $messages = ContactFormMessage::all();
        } else if(auth()->check() && auth()->user()->role == 'user') {
            // Get Messages for Authenticated User of specific Branch.
            $messages = auth()->user()->branch->messages;
        }

        if($messages) {
            // return response()->json(['data' => $messages]);

            return ContactUsResource::collection($messages);
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'No messages.'
                ]
            ]]);
        }
    }

    public function shownMessage(Request $request) 
    {
        $request->validate([
            'id' => ['required', 'exists:App\Models\ContactFormMessage,id'],
            'readMessage' => 'boolean',
        ]);

        $message = ContactFormMessage::find($request->id);

        if($message) {
            $message->read = true;
            $message->save();
            
            return response()->json(['data' => [
                'success' => true
            ]]); 
        } else {
            return response()->json(['data' => [
                'errors' => [
                    'root' => 'Message not exists.'
                ]
            ]]);
        }
    }

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
