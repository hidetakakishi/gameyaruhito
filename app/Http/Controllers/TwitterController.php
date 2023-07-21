<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterController extends Controller
{
    public function tweet(Request $request)
    {
        $user = User::where('twitter_id', session('twitter_id'))->first();

        $twitter = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            null,
            $user->access_token,
        );

        $twitter->setApiVersion("2");

        $twitter->post("tweets", ["text" => 'test'], true);

        return back();
    }

    //フォロワーか確認
    public function checkFollower(Request $request)
    {
        $user = User::where('twitter_id', session('twitter_id'))->first();

        $twitter = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            null,
            $user->access_token,
        );

        $twitter->setApiVersion("2");

        $flowers = json_decode(json_encode($twitter->get('users/' . session('twitter_id') . '/followers')), true);

        if (array_search($request->id, array_column($flowers['data'], 'id')) === false) {
            Log::debug('フォロワーではありません');
        }

        return back();
    }

    //フォロ-しているか確認
    public function checkFollowing(Request $request)
    {
        $user = User::where('twitter_id', session('twitter_id'))->first();

        $twitter = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            null,
            $user->access_token,
        );

        $twitter->setApiVersion("2");

        $following = json_decode(json_encode($twitter->get('users/' . session('twitter_id') . '/following')), true);

        if (array_search($request->id, array_column($following['data'], 'id')) === false) {
            Log::debug('相互フォローではありません');
        }

        return back();
    }

    //相互フォローか確認
    public function checkMutualFollow(Request $request)
    {
        $user = User::where('twitter_id', session('twitter_id'))->first();

        $twitter = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            null,
            $user->access_token,
        );

        $twitter->setApiVersion("2");

        $flowers = json_decode(json_encode($twitter->get('users/' . session('twitter_id') . '/followers')), true);
        $following = json_decode(json_encode($twitter->get('users/' . session('twitter_id') . '/following')), true);

        if (array_search($request->id, array_column($flowers['data'], 'id')) === false) {
            Log::debug('相互フォローではありません');
        }

        if (array_search($request->id, array_column($following['data'], 'id')) === false) {
            Log::debug('相互フォローではありません');
        }

        return back();
    }

    //デバッグ用
    public function debug(Request $request)
    {
        $user = User::where('twitter_id', session('twitter_id'))->first();

        $twitter = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            null,
            $user->access_token,
        );

        $twitter->setApiVersion("2");

        $flowers = json_decode(json_encode($twitter->get('users/' . session('twitter_id') . '/followers')), true);

        Log::debug($flowers);

        // if (array_search($request->id, array_column($flowers['data'], 'id')) === false) {
        //     Log::debug('フォロワーではありません');
        // }

        return back();
    }
}
