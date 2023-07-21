<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class ListController extends Controller
{
    public function index(Request $request)
    {
        $chatList = Chat::Join('users', 'chats.user_id', '=', 'users.id')
            ->select(
                'chats.id as id',
                'chats.title as title',
                'chats.capacity as capacity',
                'chats.limit as limit',
                'chats.unique_key as unique_key',
                'users.id as user_id',
                'users.name as name',
                'users.avatar as avatar',
                'users.twitter_screen_name as twitter_screen_name',
            )
            ->orderBy('chats.created_at', 'desc');
        // ->where('limit', '>=',  date('Y-m-d H:i:s')) // limitが現在日以降

        if (isset($request->search)) {
            $chatList = $chatList->where('chats.title', 'LIKE', '%' . $request->search . '%');
        }
        $chatList = $chatList->paginate(6);

        $index = 0;
        foreach ($chatList as $chat) {
            $chatList[$index]['user_count'] = ChatUser::where('chat_id', $chat['id'])->count();
            $chatList[$index]['user_join_flag'] = ChatUser::where('user_id', session('user_id'))->where('chat_id', $chat['id'])->exists();
            $index++;
        }

        return view('list')
            ->with('chatList', $chatList);
    }

    public function joinList(Request $request)
    {
        $chatList = Chat::Join('users', 'chats.user_id', '=', 'users.id')
            ->Join('chat_user', 'chats.id', '=', 'chat_user.chat_id')
            ->select(
                'chats.id as id',
                'chats.title as title',
                'chats.capacity as capacity',
                'chats.limit as limit',
                'chats.unique_key as unique_key',
                'users.id as user_id',
                'users.name as name',
                'users.avatar as avatar',
                'users.twitter_screen_name as twitter_screen_name',
            )
            ->where('limit', '>=',  date('Y-m-d H:i:s')) // limitが現在日以降
            ->where('chat_user.user_id', session('user_id'))
            ->orderBy('chats.created_at', 'desc');

        if (isset($request->search)) {
            $chatList = $chatList->where('chats.title', 'LIKE', '%' . $request->search . '%');
        }
        $chatList = $chatList->paginate(10);

        $index = 0;
        foreach ($chatList as $chat) {
            $chatList[$index]['user_count'] = ChatUser::where('chat_id', $chat['id'])->count();
            $chatList[$index]['user_join_flag'] = ChatUser::where('user_id', session('user_id'))->where('chat_id', $chat['id'])->exists();
            $chatList[$index]['latest_comment'] = Comment::Join('chat_user', 'comments.chat_user_id', '=', 'chat_user.id')
                ->where('chat_user.chat_id', $chat['id'])->orderBy('comments.created_at', 'desc')->first()->comment;
            $index++;
        }

        return view('join_list')
            ->with('chatList', $chatList);
    }

    public function createList(Request $request)
    {
        $chatList = Chat::Join('users', 'chats.user_id', '=', 'users.id')
            ->select(
                'chats.id as id',
                'chats.title as title',
                'chats.capacity as capacity',
                'chats.limit as limit',
                'chats.unique_key as unique_key',
                'users.id as user_id',
                'users.name as name',
                'users.avatar as avatar',
                'users.twitter_screen_name as twitter_screen_name',
            )
            ->where('limit', '>=',  date('Y-m-d H:i:s')) // limitが現在日以降
            ->orderBy('chats.created_at', 'desc');

        if (isset($request->search)) {
            $chatList = $chatList->where('chats.title', 'LIKE', '%' . $request->search . '%');
        }
        $chatList = $chatList->where('user_id', session('user_id'));
        $chatList = $chatList->paginate(5);

        $index = 0;
        foreach ($chatList as $chat) {
            $chatList[$index]['user_count'] = ChatUser::where('chat_id', $chat['id'])->count();
            $chatList[$index]['user_join_flag'] = ChatUser::where('user_id', session('user_id'))->where('chat_id', $chat['id'])->exists();
            $chatList[$index]['latest_comment'] = Comment::Join('chat_user', 'comments.chat_user_id', '=', 'chat_user.id')
                ->where('chat_user.chat_id', $chat['id'])->orderBy('comments.created_at', 'desc')->first()->comment;
            $index++;
        }

        return view('create_list')
            ->with('chatList', $chatList);
    }
}
