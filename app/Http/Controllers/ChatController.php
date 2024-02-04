<?php

namespace App\Http\Controllers;

use App\Events\MessageStoreEvent;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        return Inertia::render('Chat/index', [
            'messages' => MessageResource::collection($messages)->resolve()
        ]);
    }

    public function store(MessageRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $message = Message::create($data);

        broadcast(new MessageStoreEvent($message))->toOthers();

        return MessageResource::make($message)->resolve();
    }
}
