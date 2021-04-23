<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Branch;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use App\Models\ContactFormMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\ContactUsResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ContactUsCollectionResource;

class ContactUsController extends Controller
{
    public function index(Request $request, ContactFormMessage $contactFormMessage)
    {
        // Get All messages.
        if(auth()->check() && auth()->user()->is_admin == '1') {
            $page = $request->input('page');
            $messages = ContactFormMessage::orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);
           
        // Get Messages for Authenticated User of specific Branch.
        } else if(auth()->check() && auth()->user()->is_admin == '0') {
            $messages = auth()->user()->branch->messages;
        }
        
        if($messages) {
            return ContactUsResource::collection($messages)->response();
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
