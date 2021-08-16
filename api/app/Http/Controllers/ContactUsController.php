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
        $page = $request->input('page');
        $unreadFirst = $request->get('unreadMsgs');
        // Get an array of selected filters excluded unread Messages.
        $filterByBranchArr = explode(",", $request->get('branch_id'));
        // If filter is used
        if($filterByBranchArr[0] != ""){
             $filterByBranchArr = $filterByBranchArr;
        } else {
            $filterByBranchArr = false;
        }
        // All messages for Admin
        if(auth()->check() && auth()->user()->is_admin == '1') {

            $messages = ContactFormMessage::select('*')
                ->when($unreadFirst == 'true', function ($messages) {
                    return $messages->orderBy('read', 'asc');
                })
                ->when($filterByBranchArr, function($messages, $filterByBranchArr) {
                    return $messages->whereIn('branch_id', $filterByBranchArr);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'page', $page);

        // USER messages
        } else if(auth()->check() && auth()->user()->is_admin == '0') {

            $branchOfAuthUser = auth()->user()->branch_id;

            $messages = ContactFormMessage::select('*')
                ->where('branch_id', $branchOfAuthUser)
                ->when($unreadFirst == 'true', function($messages) {
                    return $messages->orderBy('read', 'asc');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'page', $page);
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
            'message' => ['required', 'string', 'max:500'],
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

    public function countNotifications(Request $request)
    {
        // Get All messages.
        if(auth()->check() && auth()->user()->is_admin == '1') {
            $messages = ContactFormMessage::where('read', 0)->pluck('id');

        // Get Messages for Authenticated User of specific Branch.
        } else if(auth()->check() && auth()->user()->is_admin == '0') {
            $messages = auth()->user()->branch->messages->where('read', 0)->pluck('id');
        }

        if($messages) {
            return response()
                    ->json(['data' => [count($messages)]]);
        } else {
            return response()
                    ->json(['data' => [
                        'root' => 'No unread messages'
            ]]);
        }
    }

    public function allMsgs(Request $request)
    {
        // All messages for Admin
        if(auth()->check() && auth()->user()->is_admin == '1') {

            $messages = ContactFormMessage::all();

        // USER messages
        } else if(auth()->check() && auth()->user()->is_admin == '0') {

            $branchOfAuthUser = auth()->user()->branch_id;

            $messages = ContactFormMessage::select('*')
                ->where('branch_id', $branchOfAuthUser)
                ->all();
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
}