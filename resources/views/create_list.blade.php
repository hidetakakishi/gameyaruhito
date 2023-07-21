@extends('base')

@section('saidBarJoiningListBg','bg-gray-100')

@section('title',session('name') . 'のつのりた')

@section('headerTitle','MYつのりた')

@section('content')
    <section class="body-font">
        <div class="container px-5 py-16 mx-auto mt-3">
            <div class="flex flex-wrap w-full mt-4 flex-col items-center text-center">
                <div class="flex flex-wrap w-full">
                    @foreach($chatList as $chat)
                    <div class="card relative xl:w-1/3 md:w-1/2 w-full shadow-xl mb-6 rounded-lg overflow-hidden">
                        <a href="{{ route('chat',$chat->unique_key) }}">
                        <figure><img class="joining-event cursor-pointer" src="{{ route('ogp', $chat->unique_key) }}" alt="Shoes"/></figure>
                        </a>
                        <div class="card-body">
                            <div class="flex items-center justify-start text-xs text-gray-600">
                            </div>
                            <div class="flex items-center justify-start mt-1.5">
                                <span class="text-xs text-gray-400">
                                    @php
                                        // DateTime型の値を生成
                                        $limit_date = new DateTime($chat->limit);
                                        $now_date = new DateTime();
                                        $diff = $limit_date->diff($now_date);
                                        echo $diff->format('%h時間%i分') . 'で終了';
                                    @endphp
                                </span>
                            </div>
                            <div class="absolute right-6 bottom-3">
                                <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-size="large" data-url="{{ route('chat.preview', $chat->unique_key) }}" data-hashtags="つのりた" data-lang="ja" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            <div class="flex items-center justify-center mt-8">{{ $chatList->links() }}</div>
        </div>
    </section>
@endsection