<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatUser;
use Illuminate\Support\Facades\Log;

class Ogp extends Controller
{
    public function create(Request $request)
    {
        $chat = Chat::where('unique_key', $request->chat_key)->first();
        $userCount = ChatUser::where('chat_id', $chat->id)->count();
        // OGPのサイズ
        $w = 600;
        $h = 315;
        // １行の文字数
        $partLength = 14;

        $fontSize = 24;
        $fontPath = resource_path('font/063-OTF/mplus-1p-bold.otf');

        // 画像を作成
        $image = \imagecreatetruecolor($w, $h);
        // 背景画像を描画
        $bg = \imagecreatefromjpeg(resource_path('image/ogp.jpeg'));
        imagecopyresampled($image, $bg, 0, 0, 0, 0, $w, $h, 600, 315);

        // 色を作成
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $grey = imagecolorallocate($image, 128, 128, 128);

        $title = $chat->title;
        // 各行に分割
        $parts = [];
        $length = mb_strlen($title);
        for ($start = 0; $start < $length; $start += $partLength) {
            $parts[] = mb_substr($title, $start, $partLength);
        }

        // テキストの影を描画
        // $this->drawParts($image, $parts, $w, $h, $fontSize, $fontPath, $grey, 3);
        // テキストを描画
        $this->drawText($image, $parts, $w, $h, $fontSize, $fontPath, $black);

        $userCount = '参加中 ' . ($userCount - 1) . '/' . $chat->capacity;

        $parts = [];
        $length = mb_strlen($userCount);
        for ($start = 0; $start < $length; $start += $partLength) {
            $parts[] = mb_substr($userCount, $start, $partLength);
        }

        $fontSize = 14;
        $this->drawJoinCount($image, $userCount, $w, $h, $fontSize, $fontPath, $black);

        ob_start();
        imagepng($image);
        $content = ob_get_clean();

        // 画像としてレスポンスを返す
        return response($content)
            ->header('Content-Type', 'image/png');
    }

    /**
     * 各行の描画メソッド
     */
    private function drawText($image, $parts, $w, $h, $fontSize, $fontPath, $color, $offset = 0)
    {
        foreach ($parts as $i => $part) {
            // サイズを計算
            $box = \imagettfbbox($fontSize, 0, $fontPath, $part);
            $boxWidth = $box[4] - $box[6];
            $boxHeight = $box[1] - $box[7];
            // 位置を計算
            $x = ($w - $boxWidth) / 2;
            $y = ($h / 2 + $boxHeight / 2 - $boxHeight * count($parts) * 0.5 + ($boxHeight + 15) * $i) - 10;
            \imagettftext($image, $fontSize, 0, $x + $offset, $y + $offset, $color, $fontPath, $part);
        }
    }

    /**
     * 参加人数表示
     */
    private function drawJoinCount($image, $part, $w, $h, $fontSize, $fontPath, $color, $offset = 0)
    {
        // サイズを計算
        $box = \imagettfbbox($fontSize, 0, $fontPath, $part);
        $boxWidth = $box[4] - $box[6];
        $boxHeight = $box[1] - $box[7];
        // 位置を計算
        $x = $boxWidth + 370;
        $y = $boxHeight + 40;
        \imagettftext($image, $fontSize, 0, $x + $offset, $y + $offset, $color, $fontPath, $part);
    }
}
