<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // Display user's chat list
    public function index()
    {
        if (Auth::user()->is_admin) {
            $chats = Auth::user()
                ->sellerChats()
                ->with(['buyer', 'messages'])
                ->get();
        } else {
            $chats = Auth::user()
                ->buyerChats()
                ->with(['seller', 'messages'])
                ->get();
        }

        return view('chats.chat-list', [
            'title' => 'My Chats',
            'chats' => $chats,
        ]);
    }

    // Create a chat between two users
    public function create()
    {
        //
    }

    // Store message in a chat
    public function store(Request $request)
    {
        $chat = Chat::findOrFail($request->chat);
    
        $request->validate([
            'message' => 'required|string|max:255',
        ]);
    
        $message = $chat->messages()->create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::user()->id,
            'message_text' => $request->message,
        ]);
    
        return response()->json([
            'sender_id' => $message->sender_id,
            'message_text' => $message->message_text,
            'timestamp' => $message->created_at->timezone('Asia/Jakarta')->format('H:i'),
        ]);
    }    

    // Show chat conversation between two users
    public function show(Chat $chats)
    {
        $buyer = $chats->buyer;
        $seller = $chats->seller;

        // Determine recipient based on logged-in user
        $recipient = Auth::user()->id === $seller->id ? $buyer : $seller;
    
        return view('chats.chat', [
            'title' => 'Chat',
            'chat' => $chats,
            'recipient' => $recipient,
        ]);
    }

    public function fetchMessages($chatId)
    {
        $chat = Chat::findOrFail($chatId);

        // If there's an 'after' parameter, fetch messages created after that timestamp
        $after = request()->query('after');
        $query = $chat->messages();

        if ($after) {
            $query->where('created_at', '>', \Carbon\Carbon::parse($after));
        }

        $messages = $query->get();
    
        return response()->json($messages);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
