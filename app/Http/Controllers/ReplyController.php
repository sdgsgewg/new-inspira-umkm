<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'comment_id' => 'required',
            'reply_id' => 'nullable|exists:replies,id',  // Optional for replies to comments
            'reply' => 'required|string|max:255',
        ]);

        // Get the reply_id (reply we're replying to)
        $replyId = $request->reply_id;

        // Store the reply with the correct parent_id (reply_id)
        $reply = Reply::create([
            'comment_id' => $request->comment_id,
            'parent_id' => $replyId, // Store the parent_id as the reply_id of the original reply
            'user_id' => Auth::user()->id,
            'reply_text' => $request->reply,
        ]);

        // If the reply_id exists (i.e., we're replying to another reply), fetch the user who made the original reply
        if ($replyId) {
            $parentReply = Reply::find($replyId);

            // Make sure the parent reply exists and has a user associated
            if ($parentReply && $parentReply->user) {
                $user = $parentReply->user;
            }
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reply $reply)
    {
        //
    }
}
