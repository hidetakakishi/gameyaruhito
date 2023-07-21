<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/welcome', function () {
//     return view('welcome');
// });

Route::fallback(function () { //存在しないURLは自動的にTOPにリダイレクトさせる。
    return redirect(route('list'));
});

Route::match(['get', 'post'], '/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::get('/callback', [App\Http\Controllers\LoginController::class, 'callback'])->name('callback');
Route::get('/{chat_key}/ogp.png', [App\Http\Controllers\Ogp::class, 'create'])->name('ogp');

Route::get('/list', [App\Http\Controllers\ListController::class, 'index'])->name('list');
Route::get('/list/join', [App\Http\Controllers\ListController::class, 'joinList'])->middleware('twitter.auth')->name('list.join');
Route::get('/list/create', [App\Http\Controllers\ListController::class, 'createList'])->middleware('twitter.auth')->name('list.create');

Route::get('/chat/{chat_key}', [App\Http\Controllers\ChatController::class, 'index'])->middleware('twitter.auth')->name('chat');
Route::get('/chat/preview/{chat_key}', [App\Http\Controllers\ChatController::class, 'preview'])->name('chat.preview');
Route::post('/chat/join', [App\Http\Controllers\ChatController::class, 'join'])->middleware('twitter.auth')->name('chat.join');
Route::post('/chat/create', [App\Http\Controllers\ChatController::class, 'create'])->middleware('twitter.auth')->name('chat.create');
Route::post('/chat/delete', [App\Http\Controllers\ChatController::class, 'delete'])->middleware('twitter.auth')->name('chat.delete');
Route::post('/chat/leaving', [App\Http\Controllers\ChatController::class, 'leaving'])->middleware('twitter.auth')->name('chat.leaving');

Route::post('/comment/create', [App\Http\Controllers\CommentController::class, 'create'])->middleware('twitter.auth')->name('comment.create');
Route::post('/comment/update', [App\Http\Controllers\CommentController::class, 'update'])->middleware('twitter.auth')->name('comment.update');

Route::get('/provision', [App\Http\Controllers\ProvisionController::class, 'index'])->name('provision');

// Route::post('/twitter/tweet', [App\Http\Controllers\TwitterController::class, 'tweet'])->middleware('twitter.auth')->name('twitter.tweet');
// Route::post('/twitter/checkFollower', [App\Http\Controllers\TwitterController::class, 'tweet'])->middleware('twitter.auth')->name('twitter.checkFollower');
// Route::post('/twitter/checkFollowing', [App\Http\Controllers\TwitterController::class, 'tweet'])->middleware('twitter.auth')->name('twitter.checkFollowing');
// Route::post('/twitter/checkMutualFollow', [App\Http\Controllers\TwitterController::class, 'tweet'])->middleware('twitter.auth')->name('twitter.checkMutualFollow');
// Route::post('/twitter/debug', [App\Http\Controllers\TwitterController::class, 'debug'])->middleware('twitter.auth')->name('twitter.debug');

// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/joining_list', [App\Http\Controllers\JoiningListController::class, 'index']);
