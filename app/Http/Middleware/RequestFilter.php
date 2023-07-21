<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Carbon\Carbon;
use Log;

class RequestFilter
{
    private const TWITTER_API_URL = 'https://api.twitter.com/2/oauth2/token';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('twitter_id')) {
            session()->flush();
            return redirect()->route('login');
        }
        return $next($request);
    }

    //OAUTH2.0
    // public function handle(Request $request, Closure $next)
    // {
    //     if (session()->has('twitter_id')) {
    //         // $user = User::where('twitter_id', session('twitter_id'))->first();
    //         // if (is_null($user)) {
    //         //     session()->flush();
    //         //     return redirect()->route('login');
    //         // }
    //         //以下の条件の内訳（トークン期限 < 現在日時）
    //         if (Carbon::parse(session('token_limit'))->lt(Carbon::now())) {
    //             //　リフレッシュトークンの更新はSocialiteが使用できないためHttpへルパを使用
    //             $response = Http::withHeaders([
    //                 'Accept' => 'application/json',
    //             ])->withBasicAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'))->post(self::TWITTER_API_URL, [
    //                 'grant_type' => 'refresh_token',
    //                 'client_id' => config('services.twitter.client_id'),
    //                 'client_secret' => config('services.twitter.client_secret'),
    //                 'refresh_token' => session('refresh_token'),
    //                 'client_id' => config('services.twitter.client_id'),
    //             ]);
    //             $response_array = json_decode($response->getBody(), true);

    //             Log::debug($response_array);

    //             $access_token = $response_array['access_token'];
    //             $expire_time = new Carbon('+' . $response_array['expires_in'] . ' seconds');
    //             $refresh_token = $response_array['refresh_token'];

    //             $upsert_array = [
    //                 'access_token' => $access_token,
    //                 'token_limit' => $expire_time,
    //                 'refresh_token' => $refresh_token,
    //             ];

    //             User::updateOrCreate(['twitter_id' => session('twitter_id') ?? NULL], $upsert_array);

    //             session([
    //                 'access_token' => $upsert_array['access_token'],
    //                 'token_limit' => $upsert_array['token_limit'],
    //                 'refresh_token' => $upsert_array['refresh_token'],
    //             ]);
    //         }
    //         return $next($request);
    //     }
    //     session()->flush();
    //     return redirect()->route('login');
    // }
}
