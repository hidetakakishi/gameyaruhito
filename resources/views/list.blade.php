@extends('base')

@section('saidBarListBg','bg-gray-100')

@section('headerTitle','ホーム')

@section('content')
    <section class="text-base-600 body-font">
        <div class="container px-5 py-16 mx-auto mt-4">
        <form action="{{ route('list') }}" method="get">
            <div class="relative mb-8">
            <input name="search" type="text" value="{{ request()->search }}" class="h-10 w-full pr-8 pl-5 rounded-full border-gray-300" placeholder="検索...">
            <div class="absolute top-4 right-3">
                <i class="fa fa-search text-gray-100 z-20 hover:text-gray-500"></i>
            </div>
            </div>
        </form>

            {{-- <div class="flex flex-wrap w-full mb-4 flex-col items-center text-center"> --}}
            {{-- <p class="lg:w-1/2 w-full leading-relaxed text-gray-500 text">好きな内容で募集しよう</p> --}}
            {{-- <button type="button" class="py-2 px-4 bg-red-500 hover:bg-red-600 focus:ring-red-600 focus:ring-offset-red-200 text-white w-full transition ease-in duration-200 text-center text-sm font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full mt-4 w-40 chat-create-modal-open-event">
                つのりたを作る
            </button> --}}
            {{-- </div> --}}
            <form id="form" action="" method="post">
                @csrf
                <input id="chat_id" type="hidden" name="chat_id" value="">
            </form>
                <div class="flex flex-wrap -m-4">

                    @foreach($chatList as $chat)
                            <div class="relative xl:w-1/3 md:w-1/2 w-full p-2" style="min-width: 320px">
                                <div class="shadow-sm @if(\Carbon\Carbon::parse($chat->limit)->lt(\Carbon\Carbon::now())) bg-gray-400 @else bg-white @endif p-4 rounded-lg h-36">
                                    <h2 class="text-base text-gray-900 font-medium title-font whitespace-nowrap font-extrabold mb-1">
                                        @if(28 < mb_strlen($chat->title))
                                        {{ mb_substr($chat->title ,0,28) . '...'}}
                                        @else
                                        {{ $chat->title }}
                                        @endif
                                    </h2>
                                    <div class="flex items-center justify-start mt-0.5">
                                        <img class="h-6 w-6 rounded-full" src="{{ $chat->avatar }}" alt="プロフィール">
                                        <span class="text-xs ml-2">{{ $chat->name }}</span>
                                        {{-- <span class="text-xs text-gray-500">{{ '@' . $chat->twitter_screen_name }}</span> --}}
                                    </div>
                                    <div class="mt-4">
                                        <span class="text-xs @if(\Carbon\Carbon::parse($chat->limit)->lt(\Carbon\Carbon::now())) text-black @else text-gray-400 @endif">
                                            @php
                                            if(!\Carbon\Carbon::parse($chat->limit)->lt(\Carbon\Carbon::now())) {
                                                // DateTime型の値を生成
                                                $limit_date = new DateTime($chat->limit);
                                                $now_date = new DateTime();
                                                $diff = $limit_date->diff($now_date);
                                                echo '残り' . $diff->format('%H時間%i分');
                                            } else {
                                                $limit_date = new DateTime($chat->limit);
                                                echo $limit_date->format('Y年n月H時i分') . 'に終了しました';
                                            }
                                            @endphp
                                        </span>
                                    </div>
                                    @if(!\Carbon\Carbon::parse($chat->limit)->lt(\Carbon\Carbon::now()))
                                        @if($chat->user_join_flag)
                                            <button type="button" onclick="location.href='{{ route('chat',$chat->unique_key) }}'" class="py-2 px-4 bg-pink-600 hover:bg-pink-700 focus:ring-pink-500 focus:ring-offset-pink-200 text-white w-full transition ease-in duration-200 text-center text-sm font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full mt-2 w-28 float-right joining-event right-8 bottom-8 absolute">
                                                参加中
                                            </button>
                                        @else
                                            @if($chat->capacity - ($chat->user_count - 1) > 0)
                                                <button type="button" class="py-2 px-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 focus:ring-offset-blue-200 text-white w-full transition ease-in duration-200 text-center text-sm font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full mt-2 w-28 float-right join-event right-8 bottom-8 absolute" data-value="{{ $chat->id }}" data-action="{{ route('chat.join') }}" data-title="{{ $chat->title }}">
                                                    募集中＠{{ ($chat->capacity - ($chat->user_count - 1)) }}
                                                </button>
                                            @else
                                                <button type="button" class="py-2 px-4 bg-green-500 hover:bg-green-600 focus:ring-green-500 focus:ring-offset-green-200 text-white w-full transition ease-in duration-200 text-center text-sm font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full mt-2 w-28 float-right right-8 bottom-8 absolute">
                                                    満員
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                    @endforeach
    
                </div>
            <div class="flex items-center justify-center mt-8">{{ $chatList->links() }}</div>
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