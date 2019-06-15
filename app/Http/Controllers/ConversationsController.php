<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversations;
use App\Events\NewMessage;

class ConversationsController extends Controller
{
    public function index() {
        return Conversations::select(['id', 'user', 'message'])->get()->toJson();
    }

    public function store(Request $request) {
        $randomUsernames = [
            'Anonymous',
            'Someone',
            'Some Girl',
            'Some Boy',
            'Mr. X',
            'Mr. Y',
            'Mr. ABC',
            'Ms. A',
            'Ms. B',
            'Ms. C',
        ];

        $conversation = Conversations::create([
            'message' => $request['message'],
            'user' => $randomUsernames[array_rand($randomUsernames)],
        ]);

        broadcast(new NewMessage($conversation))->toOthers();

        return response()->json($conversation);
    }
}
