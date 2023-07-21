<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\ChatUser;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        if (!session()->has('twitter_id')) {
            return redirect(route('login'));
        }

        $user_id = User::where('twitter_id', session('twitter_id'))->first()->id ?? NULL;

        Comment::create([
            'comment' => $request->comment,
            'chat_user_id' => ChatUser::where('chat_id', $request->chat_id ?? NULL)
                ->where('user_id', $user_id)->first()->id
        ]);

        $commentList = Comment::Join('chat_user', 'comments.chat_user_id', '=', 'chat_user.id')
            ->Join('users', 'chat_user.user_id', '=', 'users.id')
            ->select(
                'comments.comment as comment',
                'users.name as name',
                'users.avatar as avatar',
                'users.twitter_id as twitter_id',
                'users.twitter_screen_name as twitter_screen_name',
            )
            ->where('chat_user.chat_id', $request->chat_id ?? NULL)
            ->orderBy('comments.created_at', 'asc')->get();

        return response()->json($commentList);
    }

    public function update(Request $request)
    {
        if (!session()->has('twitter_id')) {
            return redirect(route('login'));
        }

        $commentList = Comment::Join('chat_user', 'comments.chat_user_id', '=', 'chat_user.id')
            ->Join('users', 'chat_user.user_id', '=', 'users.id')
            ->select(
                'comments.id as id',
                'comments.comment as comment',
                'users.name as name',
                'users.avatar as avatar',
                'users.twitter_id as twitter_id',
                'users.twitter_screen_name as twitter_screen_name',
            )
            ->where('chat_user.chat_id', $request->chat_id ?? NULL)
            ->orderBy('comments.created_at', 'asc')->get();

        return response()->json($commentList);
    }
}
