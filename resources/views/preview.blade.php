@extends('base')

@section('opgHead','website')

@section('showChatCreateBtn','false')

@section('ogp')
  <meta property="og:title" content="{{ $chat->name }}のつのりた" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ config('app.url') }}" />
  <meta property="og:description" content="つのりた(β)に参加する" />
  <meta property="og:image" content="{{ route('ogp', $chat->unique_key) }}">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:image" content="{{ route('ogp', $chat->unique_key) }}">
  <meta name="twitter:title" content="{{ $chat->name }}のつのりた">
  <meta name="twitter:description" content="つのりた(β)に参加する">
@endsection

@section('title',$chat->name . 'のつのりた')

@section('content')
    <form id="form" action="" method="post">
        @csrf
        <input id="chat_id" type="hidden" name="chat_id" value="">
    </form>

    <section class="body-font">
        <div class="container px-5 py-16 mx-auto mt-3">
            <div class="flex flex-wrap w-full mt-4 flex-col items-center text-center">

                <div class="shadow-lg rounded-2xl w-72 bg-white dark:bg-gray-800 p-4">
                    <p class="text-gray-800 dark:text-gray-50 text-xl font-medium mb-4">
                        {{ $chat->title }}
                    </p>
                    <div class="flex flex-col justify-center items-center">
                        <img class="h-11 w-11 rounded-full mb-1" src="{{ $chat->avatar }}" alt="プロフィール">
                        <span class="text-gray-600 dark:text-gray-300">{{$chat->name}}</span>
                    </div>
                    @if(1 < count($chatMemberList))
                    <p class="text-gray-500 dark:text-gray-100 mt-4 mb-1 font-bold">
                        参加中
                    </p>
                    @foreach($chatMemberList as $user)
                    @if($user->twitter_id != $chat->twitter_id)
                    <div class="flex flex-col justify-center items-center">
                        <img class="h-7 w-7 rounded-full mb-1" src="{{ $user->avatar }}" alt="プロフィール">
                        <span class="text-gray-500 dark:text-gray-300 text-xs">{{$user->name}}</span>
                    </div>
                    @endif
                    @endforeach
                    @endif
                    <ul class="text-sm text-gray-600 dark:text-gray-100 w-full mt-6 mb-6">
                        <li class="mb-3 flex items-center ">
                            <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" width="6" height="6" stroke="currentColor" fill="#10b981" viewBox="0 0 1792 1792">
                                <path d="M1412 734q0-28-18-46l-91-90q-19-19-45-19t-45 19l-408 407-226-226q-19-19-45-19t-45 19l-91 90q-18 18-18 46 0 27 18 45l362 362q19 19 45 19 27 0 46-19l543-543q18-18 18-45zm252 162q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z">
                                </path>
                            </svg>
                            @php
                                $limit_date = new DateTime($chat->limit);
                                $now_date = new DateTime();
                                $diff = $limit_date->diff($now_date);
                                echo '終了まで' . $diff->format('%h時間%i分');
                            @endphp
                        </li>
                        @if(($chat->capacity - ($userCount - 1)) <= 0)
                        <li class="mb-3 flex items-center opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" class="h-6 w-6 mr-2" fill="red" viewBox="0 0 1792 1792">
                                <path d="M1277 1122q0-26-19-45l-181-181 181-181q19-19 19-45 0-27-19-46l-90-90q-19-19-46-19-26 0-45 19l-181 181-181-181q-19-19-45-19-27 0-46 19l-90 90q-19 19-19 46 0 26 19 45l181 181-181 181q-19 19-19 45 0 27 19 46l90 90q19 19 46 19 26 0 45-19l181-181 181 181q19 19 45 19 27 0 46-19l90-90q19-19 19-46zm387-226q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z">
                                </path>
                            </svg>
                            参加数{{ $userCount - 1 }}/{{ $chat->capacity }}
                        </li>
                        @else
                        <li class="mb-3 flex items-center ">
                            <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" width="6" height="6" stroke="currentColor" fill="#10b981" viewBox="0 0 1792 1792">
                                <path d="M1412 734q0-28-18-46l-91-90q-19-19-45-19t-45 19l-408 407-226-226q-19-19-45-19t-45 19l-91 90q-18 18-18 46 0 27 18 45l362 362q19 19 45 19 27 0 46-19l543-543q18-18 18-45zm252 162q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z">
                                </path>
                            </svg>
                            参加数{{ $userCount - 1 }}/{{ $chat->capacity }}
                        </li>
                        @endif
                        @if($chat->followers_only_flag == true)
                        <li class="mb-3 flex items-center ">
                            <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" width="6" height="6" stroke="currentColor" fill="#10b981" viewBox="0 0 1792 1792">
                                <path d="M1412 734q0-28-18-46l-91-90q-19-19-45-19t-45 19l-408 407-226-226q-19-19-45-19t-45 19l-91 90q-18 18-18 46 0 27 18 45l362 362q19 19 45 19 27 0 46-19l543-543q18-18 18-45zm252 162q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z">
                                </path>
                            </svg>
                            フォロワーのみ
                        </li>
                        @else
                         <li class="mb-3 flex items-center opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" class="h-6 w-6 mr-2" fill="red" viewBox="0 0 1792 1792">
                                <path d="M1277 1122q0-26-19-45l-181-181 181-181q19-19 19-45 0-27-19-46l-90-90q-19-19-46-19-26 0-45 19l-181 181-181-181q-19-19-45-19-27 0-46 19l-90 90q-19 19-19 46 0 26 19 45l181 181-181 181q-19 19-19 45 0 27 19 46l90 90q19 19 46 19 26 0 45-19l181-181 181 181q19 19 45 19 27 0 46-19l90-90q19-19 19-46zm387-226q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z">
                                </path>
                            </svg>
                            フォロワーのみ
                        </li>
                        @endif
                        @if($chat->mutual_followers_only_flag == true)
                        <li class="mb-3 flex items-center ">
                            <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" width="6" height="6" stroke="currentColor" fill="#10b981" viewBox="0 0 1792 1792">
                                <path d="M1412 734q0-28-18-46l-91-90q-19-19-45-19t-45 19l-408 407-226-226q-19-19-45-19t-45 19l-91 90q-18 18-18 46 0 27 18 45l362 362q19 19 45 19 27 0 46-19l543-543q18-18 18-45zm252 162q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z">
                                </path>
                            </svg>
                            相互フォロワーのみ
                        </li>
                        @else
                         <li class="mb-3 flex items-center opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" class="h-6 w-6 mr-2" fill="red" viewBox="0 0 1792 1792">
                                <path d="M1277 1122q0-26-19-45l-181-181 181-181q19-19 19-45 0-27-19-46l-90-90q-19-19-46-19-26 0-45 19l-181 181-181-181q-19-19-45-19-27 0-46 19l-90 90q-19 19-19 46 0 26 19 45l181 181-181 181q-19 19-19 45 0 27 19 46l90 90q19 19 46 19 26 0 45-19l181-181 181 181q19 19 45 19 27 0 46-19l90-90q19-19 19-46zm387-226q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z">
                                </path>
                            </svg>
                            相互フォロワーのみ
                        </li>
                        @endif
                    </ul>
                    @if(session()->has('twitter_id'))
                        @if($chat->capacity - ($userCount - 1) > 0)
                            <button type="button" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg join-event" data-value="{{ $chat->chat_id }}" data-action="{{ route('chat.join') }}" data-title="{{ $chat->title }}">
                                参加する
                            </button>
                        @else
                            <button type="button" class="py-2 px-4  bg-red-500 hover:bg-red-600 focus:ring-red-500 focus:ring-offset-red-200 text-white w-full transition ease-in duration-200 text-center text-base shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                                満員
                            </button>
                        @endif
                    @else
                        <form action="{{ route('login') }}">
                            <button type="submit" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                                ログインして参加する
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <script>
           $(function(){
            $('.join-event').click(function() {
                if(window.confirm($(this).data('title') + 'に参加しますか？')) {
                    $('#chat_id').val($(this).data('value'));
                    $('#form').attr("action",$(this).data('action'));
                    $('#form').submit();
                    return false;
                }
            })
        });
    </script>
@endsection