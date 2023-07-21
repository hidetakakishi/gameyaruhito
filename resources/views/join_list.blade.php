@extends('base')

@section('saidBarJoinListBg','bg-gray-100')

@section('headerTitle','参加中')

@section('content')
    <div class="w-full mt-16">
        @foreach($chatList as $chat)
        <a href="{{ route('chat',$chat->unique_key) }}">
            <div class="flex flex-col px-3 py-3 h-16 bg-white cursor-pointer joining-event" style="border-bottom-width: 0.2px;">
                <div class="flex items-center justify-start flex-row">
                    <img class="h-8 w-8 rounded-full" src="{{ $chat->avatar }}" alt="プロフィール">
                    <div class="ml-3 w-full">
                        <p class="text-gray-600 text-xs">
                            @if(mb_strlen($chat->title) > 30)
                                {{ mb_substr($chat->title,0,30) . '...'}}
                            @else
                                {{ $chat->title }}
                            @endif
                            <span class="float-right text-gray-400 text-xs">{{ $chat->user_count - 1 . '/' . $chat->capacity }}人</span>
                        </p>
                        <p class="text-gray-400 text-xs tracking-wide">
                            @if(mb_strlen($chat->latest_comment) > 20)
                                {{ mb_substr($chat->latest_comment,0,20) . '...'}}
                            @else
                                {{ $chat->latest_comment }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
@endsection