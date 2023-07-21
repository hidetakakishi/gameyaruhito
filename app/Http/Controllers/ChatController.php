<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Comment;
use Carbon\Carbon;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $chat = Chat::Join('users', 'chats.user_id', '=', 'users.id')
            ->select(
                'chats.id as chat_id',
                'chats.title as title',
                'chats.capacity as capacity',
                'chats.followers_only_flag as followers_only_flag',
                'chats.mutual_followers_only_flag as mutual_followers_only_flag',
                'chats.limit as limit',
                'chats.unique_key as unique_key',
                'users.id as user_id',
                'users.twitter_id as twitter_id',
                'users.twitter_screen_name as twitter_screen_name',
                'users.name as name',
                'users.avatar as avatar',
            )->where('unique_key', $request->chat_key)->first();

        if ($chat === null) {
            return back()->with('alert_error_message', '募集が見つかりませんでした。');
        }

        if (ChatUser::where('chat_id', $chat->chat_id)->where('user_id', session('user_id'))->exists() == false) {
            return back()->with('alert_error_message', '参加権限がありません。');
        }

        // 期限確認
        if (Carbon::parse($chat->limit)->lt(Carbon::now())) {
            return back()->with('alert_error_message', 'この募集は終了しました');
        }

        $commentList = Comment::Join('chat_user', 'comments.chat_user_id', '=', 'chat_user.id')
            ->Join('users', 'chat_user.user_id', '=', 'users.id')
            ->select(
                'comments.comment as comment',
                'users.name as name',
                'users.avatar as avatar',
                'users.twitter_id as twitter_id',
            )
            ->where('chat_user.chat_id', $chat->chat_id)
            ->orderBy('comments.created_at', 'asc')->get();

        $userCount = ChatUser::where('chat_id', $chat->chat_id)->count();

        $chatMemberList = ChatUser::where('chat_id', $chat->chat_id)
            ->Join('users', 'chat_user.user_id', '=', 'users.id')
            ->select(
                'users.name as name',
                'users.avatar as avatar',
                'users.twitter_id as twitter_id',
                'users.twitter_screen_name as twitter_screen_name',
            )
            ->get();

        return view('chat')
            ->with('chat', $chat)
            ->with('commentList', $commentList)
            ->with('userCount', $userCount)
            ->with('chatMemberList', $chatMemberList);
    }

    public function preview(Request $request)
    {
        $chat = Chat::Join('users', 'chats.user_id', '=', 'users.id')
            ->select(
                'chats.id as chat_id',
                'chats.title as title',
                'chats.capacity as capacity',
                'chats.followers_only_flag as followers_only_flag',
                'chats.mutual_followers_only_flag as mutual_followers_only_flag',
                'chats.limit as limit',
                'chats.unique_key as unique_key',
                'users.id as user_id',
                'users.twitter_id as twitter_id',
                'users.twitter_screen_name as twitter_screen_name',
                'users.name as name',
                'users.avatar as avatar',
            )->where('unique_key', $request->chat_key)->first();

        if ($chat === null) {
            return back()->with('alert_error_message', '募集が見つかりませんでした。');
        }

        $userCount = ChatUser::where('chat_id', $chat->chat_id)->count();

        $chatMemberList = ChatUser::where('chat_id', $chat->chat_id)
            ->Join('users', 'chat_user.user_id', '=', 'users.id')
            ->select(
                'users.name as name',
                'users.avatar as avatar',
                'users.twitter_id as twitter_id',
                'users.twitter_screen_name as twitter_screen_name',
            )
            ->get();

        return view('preview')
            ->with('chat', $chat)
            ->with('userCount', $userCount)
            ->with('chatMemberList', $chatMemberList);
    }

    public function join(Request $request)
    {
        $chat = Chat::Join('users', 'chats.user_id', '=', 'users.id')
            ->select(
                'chats.id as chat_id',
                'chats.capacity as capacity',
                'chats.followers_only_flag as followers_only_flag',
                'chats.mutual_followers_only_flag as mutual_followers_only_flag',
                'chats.unique_key as unique_key',
                'chats.limit as limit',
                'users.id as user_id',
                'users.twitter_id as twitter_id',
            )
            ->where('chats.id', $request->chat_id)->first();

        if ($chat === null) {
            return back()->with('alert_error_message', '募集が見つかりませんでした。');
        }

        // 期限確認
        if (Carbon::parse($chat->limit)->lt(Carbon::now())) {
            return back()->with('alert_error_message', 'この募集は終了しました');
        }

        // 定員確認
        $chatUserCount = ChatUser::where('chat_id', $request->chat_id)->count();
        if ($chatUserCount > $chat->capacity) {
            return back()->with('alert_error_message', '満員です。');
        }

        // フォロワー確認（twitterログイン廃止のためコメントアウト）
        // if ($chat->followers_only_flag == 1) {
        //     $twitterOauth = new TwitterOAuth(
        //         config('services.twitter.client_id'),
        //         config('services.twitter.client_secret'),
        //         session('access_token'),
        //         session('refresh_token'),
        //     );

        //     $following = json_decode(json_encode($twitterOauth->get("friends/list")), true);
        //     if (array_search($chat->twitter_id, array_column($following['users'], 'id_str')) === false) {
        //         return back()->with('alert_error_message', 'フォロワーではありません。');
        //     }
        // }

        // 相互フォロワー確認（twitterログイン廃止のためコメントアウト）
        // if ($chat->mutual_followers_only_flag == 1) {
        //     $twitterOauth = new TwitterOAuth(
        //         config('services.twitter.client_id'),
        //         config('services.twitter.client_secret'),
        //         session('access_token'),
        //         session('refresh_token'),
        //     );

        //     $flowers = json_decode(json_encode($twitterOauth->get('followers/list')), true);
        //     $following = json_decode(json_encode($twitterOauth->get('friends/list')), true);

        //     if (array_search($chat->twitter_id, array_column($flowers['users'], 'id_str')) === false) {
        //         return back()->with('alert_error_message', '相互フォローではありません。');
        //     }

        //     if (array_search($chat->twitter_id, array_column($following['users'], 'id_str')) === false) {
        //         return back()->with('alert_error_message', '相互フォローではありません。');
        //     }
        // }

        // 参加済み確認
        if (ChatUser::where('chat_id', $chat->chat_id)->where('user_id', session('user_id'))->exists() == true) {
            return back()->with('alert_error_message', '既に参加しています。');
        }

        // ChatUserテーブルが重複確認
        try {
            $chatUser = ChatUser::create([
                'chat_id' => $chat->chat_id,
                'user_id' => session('user_id'),
            ]);
        } catch (\Exception $e) {
            return back()->with('alert_error_message', '既に参加しています。');
        }

        Comment::create([
            'comment' => session('name') . 'が参加しました。',
            'chat_user_id' => $chatUser->id
        ]);
        return redirect()->route('chat', $chat->unique_key);
    }

    public function create(Request $request)
    {
        $title = $request->title ?? '';
        $capacity = $request->capacity ?? 0;
        $followersOnly = $request->followersOnly ?? 0;
        $mutualFollowersOnly = $request->mutualFollowersOnly ?? 0;

        if ($capacity == 0 || $title == '') {
            return back()->with('alert_error_message', '入力データが不正です。');
        }
        if ($followersOnly == 1 && $mutualFollowersOnly == 1) {
            return back()->with('alert_error_message', '入力データが不正です。');
        }
        $chat = Chat::create([
            'title' => $title,
            'detail' => '',
            'capacity' => $capacity,
            'followers_only_flag' => $followersOnly,
            'mutual_followers_only_flag' => $mutualFollowersOnly,
            'limit' => Carbon::now()->addDays(1),
            'user_id' => session('user_id'),
            'unique_key' => Uuid::uuid4(),
        ]);

        try {
            $chatUser = ChatUser::create([
                'chat_id' => $chat->id,
                'user_id' => session('user_id'),
            ]);
        } catch (\Exception $e) {
            return back()->with('alert_error_message', '既に参加しています。');
        }

        Comment::create([
            'comment' => session('name') . 'が' . $chat->title . 'を作成しました。',
            'chat_user_id' => $chatUser->id
        ]);

        return redirect()->route('list')->with('alert_succes_message', '募集を作成しました。');
    }

    public function delete(Request $request)
    {
        $chat_id = $request->chat_id ?? '';

        if ($chat_id == '') {
            return back();
        }

        Chat::destroy($chat_id);

        return redirect()->route('list')->with('alert_succes_message', '募集が削除されました。');
    }

    public function leaving(Request $request)
    {
        $chat_id = $request->chat_id ?? '';

        if ($chat_id == '') {
            return back();
        }

        ChatUser::where('chat_id', $chat_id)
            ->where('user_id', session('user_id'))
            ->delete();

        return redirect()->route('list')->with('alert_succes_message', '募集から退出しました。');
    }

    //Oauth2.0
    // public function join(Request $request)
    // {
    //     $chat = Chat::Join('users', 'chats.user_id', '=', 'users.id')
    //     ->select(
    //         'chats.id as chat_id',
    //         'chats.capacity as capacity',
    //         'chats.followers_only_flag as followers_only_flag',
    //         'chats.mutual_followers_only_flag as mutual_followers_only_flag',
    //         'users.id as user_id',
    //         'users.twitter_id as twitter_id',
    //     )
    //         ->where('chats.id', $request->chat_id)->first();

    //     // 定員確認
    //     $chatUserCount = ChatUser::where('chat_id', $request->chat_id)->count();
    //     if ($chatUserCount > $chat->capacity) {
    //         Log::debug('定員オーバーです');
    //         return redirect()->route('list');
    //     }

    //     // フォロワー確認
    //     if ($chat->followers_only_flag == 1) {
    //         $twitter = new TwitterOAuth(
    //             config('services.twitter.client_id'),
    //             config('services.twitter.client_secret'),
    //             null,
    //             session('access_token'),
    //         );
    //         $twitter->setApiVersion("2");
    //         $following = json_decode(json_encode($twitter->get('users/' . session('twitter_id') . '/following')), true);

    //         if (array_search($chat->twitter_id, array_column($following['data'], 'id')) === false) {
    //             Log::debug('フォロワーではありません');
    //             return redirect()->route('list');
    //         }
    //     }

    //     // 相互フォロワー確認
    //     if ($chat->mutual_followers_only_flag == 1) {
    //         $twitter = new TwitterOAuth(
    //             config('services.twitter.client_id'),
    //             config('services.twitter.client_secret'),
    //             null,
    //             session('access_token'),
    //         );
    //         $twitter->setApiVersion("2");
    //         $flowers = json_decode(json_encode($twitter->get('users/' . session('twitter_id') . '/flowers')), true);
    //         $following = json_decode(json_encode($twitter->get('users/' . session('twitter_id') . '/following')), true);

    //         if (array_search($chat->twitter_id, array_column($flowers['data'], 'id')) === false) {
    //             Log::debug('相互フォローではありません');
    //             return redirect()->route('list');
    //         }

    //         if (array_search($chat->twitter_id, array_column($following['data'], 'id')) === false) {
    //             Log::debug('相互フォローではありません');
    //             return redirect()->route('list');
    //         }
    //     }

    //     // ChatUserテーブルが重複確認
    //     try {
    //         $chatUser = ChatUser::create([
    //             'chat_id' => $chat->chat_id,
    //             'user_id' => session('user_id'),
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::debug('ChatUserテーブルが重複');
    //         return redirect()->route('list');
    //     }

    //     Comment::create([
    //         'comment' => session('name') . 'が参加しました。',
    //         'chat_user_id' => $chatUser->id
    //     ]);
    //     return redirect(route('chat'), 307);
    // }
}
