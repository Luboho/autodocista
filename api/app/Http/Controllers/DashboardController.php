<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactFormMessage;
use App\Http\Resources\ContactUsResource;

class DashboardController extends Controller
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

    public function readMessage(Request $request) 
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
}
