<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

// ★★★★★★開発メモ★★★★★★
// 下記アカウントgoogleAPIコンソールから設定
// superkishisama@gmail.com
// 設定手順は下記公式ドキュメント参考
// https://developers.google.com/identity/protocols/oauth2/web-server?hl=ja#creatingclient
// 試行錯誤の末Socialiteを使うことになった

class LoginController extends Controller
{
    public function index(Request $request)
    {
        //Google Clientオブジェクト作成
        session(['current_url' => url()->previous()]);
        return Socialite::driver('google')->redirect();                
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('list')->with('alert_succes_message', 'ログアウトしました');
    }

    public function callback()
    {
        try {
            //ユーザー情報取得
            $twitterInfo = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect(route('list'))->with('alert_error_message', '予期せぬエラーが発生しました');
        }
        // Log::debug(json_decode(json_encode($twitterInfo), true));
        $twitterInfo = json_decode(json_encode($twitterInfo), true);

        $upsert_array = [
            'twitter_id' => $twitterInfo['id'],
            'twitter_screen_name' => $twitterInfo['nickname'] ?? "",
            'name' => $twitterInfo['name'],
            'avatar' => $twitterInfo['avatar'],
            'access_token' => $twitterInfo['token'],
            'refresh_token' => $twitterInfo['refreshToken'] ?? "",
            'token_limit' => new Carbon(),
        ];

        // TwitterIDを条件にupsert
        $user = User::updateOrCreate(['twitter_id' => $upsert_array['twitter_id'] ?? NULL], $upsert_array);

        //セッションにTwitterIDを保存
        session([
            'user_id' => $user->id,
            'twitter_id' => $upsert_array['twitter_id'],
            'name' => $upsert_array['name'],
            'twitter_screen_name' => $upsert_array['twitter_screen_name'],
            'access_token' => $upsert_array['access_token'],
            'refresh_token' => $upsert_array['refresh_token'],
            'token_limit' => $upsert_array['token_limit'],
            'avatar' => $upsert_array['avatar'],
        ]);

        return redirect(session('current_url'))->with('alert_succes_message', 'ログインしました。');
    }

    // リフレッシュトークン更新用のコールバック処理
    // public function callback()
    // {
    //     try {
    //         $socialiteUser = Socialite::driver('google')->user();
    //         $email = $socialiteUser->email;
    //     } catch (Exception $e) {
    //         return redirect(route('list'))->with('alert_error_message', '予期せぬエラーが発生しました');
    //     }
    //     Log::debug(json_decode(json_encode($socialiteUser), true));
    //     try {
    //         //ユーザー情報取得
    //         $user = Socialite::driver('twitter')->user();
    //     } catch (\Exception $e) {
    //         return redirect(route('list'))->with('alert_succes_message', '予期せぬエラーが発生しました');
    //     }
    //     Log::debug(json_decode(json_encode($user), true));
    //     //トークンが期限切れになる時間
    //     $expires_in = $user->expiresIn;
    //     $expire_time = new Carbon('+' . $expires_in . ' seconds');

    //     $upsert_array = [
    //         'twitter_id' => $user->getId(),
    //         'twitter_screen_name' => $user->getNickname(),
    //         'name' => $user->getName(),
    //         'avatar' => $user->getAvatar(),
    //         'access_token' => $user->token,
    //         'refresh_token' => $user->refreshToken,
    //         'token_limit' => $expire_time,
    //     ];

    //     Log::debug($upsert_array['access_token']);

    //     // TwitterIDを条件にupsert
    //     $user = User::updateOrCreate(['twitter_id' => $upsert_array['twitter_id'] ?? NULL], $upsert_array);

    //     //セッションにTwitterIDを保存
    //     session([
    //         'user_id' => $user->id,
    //         'twitter_id' => $upsert_array['twitter_id'],
    //         'name' => $upsert_array['name'],
    //         'twitter_screen_name' => $upsert_array['twitter_screen_name'],
    //         'access_token' => $upsert_array['access_token'],
    //         'refresh_token' => $upsert_array['refresh_token'],
    //         'token_limit' => $upsert_array['token_limit'],
    //         'avatar' => $upsert_array['avatar'],
    //     ]);

    //     return redirect()->route('list')->with('flash_message', 'ログインしました');
    // }
}
