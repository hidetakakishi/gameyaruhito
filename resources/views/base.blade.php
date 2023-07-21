<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# @yield('opgHead','article'): http://ogp.me/ns/@yield('opgHead','article')#">
        @section('ogp')
            <meta property="og:title" content="つのりた(β)" />
            <meta property="og:type" content="@yield('opgHead','article')" />
            <meta property="og:url" content="{{ config('app.url') }}" />
            <meta property="og:description" content="twitterと連携していろんな募集ができるサービス" />
            <meta property="og:image" content="{{ asset('image/main-ogp.png') }}">

            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:image" content="{{ asset('image/main-ogp.png') }}">
            <meta name="twitter:title" content="つのりた(β)">
            <meta name="twitter:description" content="twitterと連携していろんな募集ができるサービス">
        @show

        <link rel="icon" href="{{ asset('image/270b.svg') }}" id="favicon">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon-180x180.png') }}">
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','つのりた')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                /* font-family: 'Nunito', sans-serif; */
                /* background-color:#f3f4f6;
                height:100vh;
                height: -webkit-fill-available; */
            }
            header {
                position: fixed;
                width: 100%;
                top: 0;
                z-index: 10000;
            }
            .chat-create-btn {
                position: fixed;
                cursor: pointer;
                bottom: 5%;
                right: 20px;
                transform: translateY(-50%);
                background-color: rgb(239 68 68);
                display: block;
                width: 64px;
                height: 64px;
                text-indent: 100%;
                white-space: nowrap;
                overflow: hidden;
                border-radius: 50%;
            }
            .chat-create-btn:before, .chat-create-btn:after {
                display: block;
                content: '';
                background-color: #fff;
                position: absolute;
                width: 15px;
                height: 2px;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            .chat-create-btn:before {
                width: 2px;
                height: 15px;
            }
            @keyframes slideOpen{
                0% {transform: translateX(-400px);}
                100%{transform: translateX(0);}
            }
            @keyframes slideHide{
                0%{transform: translateX(0);}
                100% {transform: translateX(-400px);}
            }
            .slide-menu-open {
                animation-name:slideOpen;
                animation-duration: 0.6s;
            }
            .slide-menu-hide {
                animation-name:slideHide;
                animation-duration: 0.6s;
            }
            @keyframes slideBgOpen{
                0% {background-color: rgb(75, 85, 99,0);}
                100%{background-color: rgb(75, 85, 99,0.4);}
            }
            @keyframes slideBgHide{
                0%{background-color: rgb(75, 85, 99,0.4);}
                100% {background-color: rgb(75, 85, 99,0);}
            }
            .slide-menu-bg-open {
                animation-name:slideBgOpen;
                animation-duration: 0.3s;
            }
            .slide-menu-bg-hide {
                animation-name:slideBgHide;
                animation-duration: 0.3s;
            }
        </style>
       <meta name="csrf-token" content="{{ csrf_token() }}">
       <link href="{{ asset('css/app.css') }}" rel="stylesheet">
       <script src="{{ asset('js/app.js') }}"></script>
       <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
       <script src="https://unpkg.com/v8n/dist/v8n.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.12/push.min.js"></script>
    </head>
    <body class="bg-gray-100">
    <header>
        <div class="relative hidden bg-gray-600/40" id="slide-menu-bg">
            <div class="flex flex-row">
                <div class="w-4/6 h-screen bg-white hidden" id="slide-menu" style="min-width: 240px">
                    <div class="flex items-center justify-start mx-6 mt-10">
                        <img class="h-10 w-10 rounded-full" src="{{ session('avatar') }}" alt="プロフィール">
                        <span class="text-gray-600 dark:text-gray-300 ml-4 font-bold">
                            {{ session('name') }}<br><span class="text-sm text-gray-400">{{ '@' . session('twitter_screen_name') }}</span>
                        </span>
                    </div>
                    <nav class="mt-10 px-6">
                        <a id="saidBarHome" class="hover:text-gray-800 hover:bg-gray-100 flex items-center p-2 my-6 transition-colors dark:hover:text-white dark:hover:bg-gray-600 duration-200  text-gray-600 dark:text-gray-400 rounded-lg @yield('saidBarListBg')" href="{{ route('list') }}">
                            {{-- <svg width="20" height="20" fill="currentColor" class="m-auto" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1024 1131q0-64-9-117.5t-29.5-103-60.5-78-97-28.5q-6 4-30 18t-37.5 21.5-35.5 17.5-43 14.5-42 4.5-42-4.5-43-14.5-35.5-17.5-37.5-21.5-30-18q-57 0-97 28.5t-60.5 78-29.5 103-9 117.5 37 106.5 91 42.5h512q54 0 91-42.5t37-106.5zm-157-520q0-94-66.5-160.5t-160.5-66.5-160.5 66.5-66.5 160.5 66.5 160.5 160.5 66.5 160.5-66.5 66.5-160.5zm925 509v-64q0-14-9-23t-23-9h-576q-14 0-23 9t-9 23v64q0 14 9 23t23 9h576q14 0 23-9t9-23zm0-260v-56q0-15-10.5-25.5t-25.5-10.5h-568q-15 0-25.5 10.5t-10.5 25.5v56q0 15 10.5 25.5t25.5 10.5h568q15 0 25.5-10.5t10.5-25.5zm0-252v-64q0-14-9-23t-23-9h-576q-14 0-23 9t-9 23v64q0 14 9 23t23 9h576q14 0 23-9t9-23zm256-320v1216q0 66-47 113t-113 47h-352v-96q0-14-9-23t-23-9h-64q-14 0-23 9t-9 23v96h-768v-96q0-14-9-23t-23-9h-64q-14 0-23 9t-9 23v96h-352q-66 0-113-47t-47-113v-1216q0-66 47-113t113-47h1728q66 0 113 47t47 113z">
                                </path>
                            </svg> --}}
                            <span class="mx-4 text-lg font-normal">
                                参加する
                            </span>
                            <span class="flex-grow text-right">
                            </span>
                        </a>
                        @if(session()->has('twitter_id'))
                            <a id="saidBarJoin" class="hover:text-gray-800 hover:bg-gray-100 flex items-center p-2 my-6 transition-colors dark:hover:text-white dark:hover:bg-gray-600 duration-200  text-gray-800 dark:text-gray-100 rounded-lg @yield('saidBarJoinListBg')" href="{{ route('list.join') }}">
                                {{-- <svg width="20" height="20" fill="currentColor" class="m-auto" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M685 483q16 0 27.5-11.5t11.5-27.5-11.5-27.5-27.5-11.5-27 11.5-11 27.5 11 27.5 27 11.5zm422 0q16 0 27-11.5t11-27.5-11-27.5-27-11.5-27.5 11.5-11.5 27.5 11.5 27.5 27.5 11.5zm-812 184q42 0 72 30t30 72v430q0 43-29.5 73t-72.5 30-73-30-30-73v-430q0-42 30-72t73-30zm1060 19v666q0 46-32 78t-77 32h-75v227q0 43-30 73t-73 30-73-30-30-73v-227h-138v227q0 43-30 73t-73 30q-42 0-72-30t-30-73l-1-227h-74q-46 0-78-32t-32-78v-666h918zm-232-405q107 55 171 153.5t64 215.5h-925q0-117 64-215.5t172-153.5l-71-131q-7-13 5-20 13-6 20 6l72 132q95-42 201-42t201 42l72-132q7-12 20-6 12 7 5 20zm477 488v430q0 43-30 73t-73 30q-42 0-72-30t-30-73v-430q0-43 30-72.5t72-29.5q43 0 73 29.5t30 72.5z">
                                    </path>
                                </svg> --}}
                                <span class="mx-4 text-lg font-normal">
                                    募集する
                                </span>
                                <span class="flex-grow text-right">
                                </span>
                            </a>
                            <a id="saidBarJoin" class="hover:text-gray-800 hover:bg-gray-100 flex items-center p-2 my-6 transition-colors dark:hover:text-white dark:hover:bg-gray-600 duration-200  text-gray-800 dark:text-gray-100 rounded-lg @yield('saidBarJoiningListBg')" href="{{ route('list.create') }}">
                                {{-- <svg width="20" height="20" fill="currentColor" class="m-auto" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M685 483q16 0 27.5-11.5t11.5-27.5-11.5-27.5-27.5-11.5-27 11.5-11 27.5 11 27.5 27 11.5zm422 0q16 0 27-11.5t11-27.5-11-27.5-27-11.5-27.5 11.5-11.5 27.5 11.5 27.5 27.5 11.5zm-812 184q42 0 72 30t30 72v430q0 43-29.5 73t-72.5 30-73-30-30-73v-430q0-42 30-72t73-30zm1060 19v666q0 46-32 78t-77 32h-75v227q0 43-30 73t-73 30-73-30-30-73v-227h-138v227q0 43-30 73t-73 30q-42 0-72-30t-30-73l-1-227h-74q-46 0-78-32t-32-78v-666h918zm-232-405q107 55 171 153.5t64 215.5h-925q0-117 64-215.5t172-153.5l-71-131q-7-13 5-20 13-6 20 6l72 132q95-42 201-42t201 42l72-132q7-12 20-6 12 7 5 20zm477 488v430q0 43-30 73t-73 30q-42 0-72-30t-30-73v-430q0-43 30-72.5t72-29.5q43 0 73 29.5t30 72.5z">
                                    </path>
                                </svg> --}}
                                <span class="mx-4 text-lg font-normal">
                                    参加中
                                </span>
                                <span class="flex-grow text-right">
                                </span>
                            </a>

                            <a class="hover:text-gray-800 hover:bg-gray-100 flex items-center p-2 my-6 transition-colors dark:hover:text-white dark:hover:bg-gray-600 duration-200  text-gray-600 dark:text-gray-400 rounded-lg @yield('saidBarProvisionBg')" href="{{ route('provision') }}">
                                {{-- <svg width="20" height="20" fill="currentColor" class="m-auto" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M960 0l960 384v128h-128q0 26-20.5 45t-48.5 19h-1526q-28 0-48.5-19t-20.5-45h-128v-128zm-704 640h256v768h128v-768h256v768h128v-768h256v768h128v-768h256v768h59q28 0 48.5 19t20.5 45v64h-1664v-64q0-26 20.5-45t48.5-19h59v-768zm1595 960q28 0 48.5 19t20.5 45v128h-1920v-128q0-26 20.5-45t48.5-19h1782z">
                                    </path>
                                </svg> --}}
                                <span class="mx-4 text-lg font-normal">
                                    使い方
                                </span>
                                <span class="flex-grow text-right">
                                    {{-- <button type="button" class="w-6 h-6 text-xs  rounded-full text-white bg-red-500">
                                        <span class="p-1">
                                            7
                                        </span>
                                    </button> --}}
                                </span>
                            </a>

                            <a class="hover:text-gray-800 hover:bg-gray-100 flex items-center p-2 my-6 transition-colors dark:hover:text-white dark:hover:bg-gray-600 duration-200  text-gray-600 dark:text-gray-400 rounded-lg " href="{{ route('logout') }}">
                                {{-- <svg width="20" height="20" fill="currentColor" class="m-auto" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M960 0l960 384v128h-128q0 26-20.5 45t-48.5 19h-1526q-28 0-48.5-19t-20.5-45h-128v-128zm-704 640h256v768h128v-768h256v768h128v-768h256v768h128v-768h256v768h59q28 0 48.5 19t20.5 45v64h-1664v-64q0-26 20.5-45t48.5-19h59v-768zm1595 960q28 0 48.5 19t20.5 45v128h-1920v-128q0-26 20.5-45t48.5-19h1782z">
                                    </path>
                                </svg> --}}
                                <span class="mx-4 text-lg font-normal">
                                    ログアウト
                                </span>
                                <span class="flex-grow text-right">
                                    {{-- <button type="button" class="w-6 h-6 text-xs  rounded-full text-white bg-red-500">
                                        <span class="p-1">
                                            7
                                        </span>
                                    </button> --}}
                                </span>
                            </a>
                        @endif
                        {{-- <a class="hover:text-gray-800 hover:bg-gray-100 flex items-center p-2 my-6 transition-colors dark:hover:text-white dark:hover:bg-gray-600 duration-200  text-gray-600 dark:text-gray-400 rounded-lg " href="#">
                            <svg width="20" height="20" class="m-auto" fill="currentColor" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1070 1178l306-564h-654l-306 564h654zm722-282q0 182-71 348t-191 286-286 191-348 71-348-71-286-191-191-286-71-348 71-348 191-286 286-191 348-71 348 71 286 191 191 286 71 348z">
                                </path>
                            </svg>
                            <span class="mx-4 text-lg font-normal">
                                Navigation
                            </span>
                            <span class="flex-grow text-right">
                            </span>
                        </a> --}}
                        <div class="absolute my-10" style="min-width: 240px; bottom:10%">
                            <a class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition-colors duration-200 flex items-center py-2 px-8" href="https://twitter.com/DevPapion">
                                <svg width="20" fill="currentColor" height="20" class="h-5 w-5" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1088 1256v240q0 16-12 28t-28 12h-240q-16 0-28-12t-12-28v-240q0-16 12-28t28-12h240q16 0 28 12t12 28zm316-600q0 54-15.5 101t-35 76.5-55 59.5-57.5 43.5-61 35.5q-41 23-68.5 65t-27.5 67q0 17-12 32.5t-28 15.5h-240q-15 0-25.5-18.5t-10.5-37.5v-45q0-83 65-156.5t143-108.5q59-27 84-56t25-76q0-42-46.5-74t-107.5-32q-65 0-108 29-35 25-107 115-13 16-31 16-12 0-25-8l-164-125q-13-10-15.5-25t5.5-28q160-266 464-266 80 0 161 31t146 83 106 127.5 41 158.5z">
                                    </path>
                                </svg>
                                <span class="mx-4 font-medium">
                                    お問い合わせ
                                </span>
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="w-2/6" id="slide-menu-close">
                </div>
            </div>
        </div>

        <nav class="border-b bg-white">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        {{-- <img class="h-10 w-10 rounded-full" src="{{ asset('image/icon.png') }}" alt="プロフィール"> --}}
                        {{-- <a class="text-lg font-bold chat-create-modal-open-event demo_button" href="#">@yield('headerTitle','つのりた')</a> --}}
                        <a class="text-lg font-bold chat-create-modal-open-event demo_button" href="#">ゲームやるひと✋</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a href="{{ route('list') }}" class="px-3 py-2 rounded-md text-sm font-medium" aria-current="page">参加する</a>
                        
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium chat-create-modal-open-event">募集する</a>
                        @if(session()->has('twitter_id'))

                        <a href="{{ route('list.join') }}" class="px-3 py-2 rounded-md text-sm font-medium">参加中</a>
                        @endif

                        {{-- <a href="{{ route('list.create') }}" class="px-3 py-2 rounded-md text-sm font-medium">募集する一覧</a> --}}

                        <a href="{{ route('provision') }}" class="px-3 py-2 rounded-md text-sm font-medium">使い方</a>
                        @if(session()->has('twitter_id'))

                        <a href="{{ route('logout') }}" class="px-3 py-2 rounded-md text-sm font-medium">ログアウト</a>
                        @endif
                        
                        {{-- <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Calendar</a> --}}
                    </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 left-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    
                    {{-- <button type="button" class="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span class="sr-only">View notifications</span>
                    <!-- Heroicon name: outline/bell -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    </button> --}}

                    <div class="relative ml-3">
                    <div>
                        @if(session()->has('twitter_id'))
                            <button class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <img class="h-8 w-8 rounded-full" src="{{ session('avatar') }}" alt="プロフィール">
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium" aria-current="page">ログイン</a>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </nav>

    </header>
    <div id="alert-success" class="flex justify-center items-center py-1 px-2 rounded-full bg-green-400 fixed left-1/2 z-50" style="transform : translate(-50%, -50%); display:none; top:5.5rem">
        <div slot="avatar">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div id="alert-success-text" class="text-xs font-normal  max-w-full flex-initial mx-1"></div>
    </div>
    <div id="alert-warning" class="flex justify-center items-center py-1 px-2 rounded-full bg-amber-400 fixed left-1/2 z-50" style="transform : translate(-50%, -50%); display:none; top:5.5rem">
        <div slot="avatar">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div id="alert-warning-text" class="text-xs font-normal  max-w-full flex-initial mx-1"></div>
    </div>
    <div id="alert-error" class="flex justify-center items-center py-1 px-2 rounded-full bg-red-500 fixed left-1/2 z-50" style="transform : translate(-50%, -50%); display:none; top:5.5rem">
        <div slot="avatar">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div id="alert-error-text" class="text-xs font-normal max-w-full flex-initial mx-1"></div>
        {{-- <div class="flex flex-auto flex-row-reverse">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-red-400 rounded-full w-5 h-5 ml-2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </div>
        </div> --}}
    </div>
    <main class="bg-gray-100">
        @yield('content')
    </main>
    <div id="chat-create-modal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity chat-create-modal-close-event"></div>
            <div class="flex min-h-full justify-center p-4 text-center items-center sm:p-0">
                <div class="lg:w-1/3 md:w-1/2 bg-white rounded-lg p-8 flex flex-col w-full mt-10 md:mt-0 relative z-10 shadow-md">

                    <form id="base-form" action="{{ route('chat.create') }}" method="post">
                            @csrf
                        <input id="base-chat-id" type="hidden" name="chat_id" value="">

                        <h2 class="text-gray-900 text-lg mb-6 font-bold title-font">募集する</h2>
                        <div class="mb-2.5">
                            <input id="title" type="text" name="title" placeholder="タイトル" class="w-full bg-white rounded-full border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="flex justify-center">
                        <div class="mb-6 w-full">
                            <select name="capacity" id="capacity" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded-full transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example">
                                <option class="text-gray-300" value="0">人数</option>
                                @for($i=1;$i <= 10;$i++)
                                    <option value="{{ $i }}">{{ $i }}人</option>
                                @endfor
                            </select>
                        </div>
                        </div>
                        {{-- <div class="relative mb-4">
                            <label for="message" class="leading-7 text-sm text-gray-600">詳細説明</label>
                            <textarea name="detail" class="w-full bg-white rounded border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div> --}}

                        {{-- <div class="flex flex-col justify-center items-center mb-3">
                            <div class="flex items-center form-check form-check-inline space-x-2">
                                <input class="restrictionRadio" type="radio" name="followersOnly" id="followers-only" value="1">
                                <label class="form-check-label inline-block text-gray-800 text-sm" for="inlineRadio10">フォロワーのみ</label>
                            </div>
                            <div class="flex items-center form-check form-check-inline space-x-2 ml-7">
                                <input class="restrictionRadio" type="radio" name="mutualFollowersOnly" id="mutual-followers-only" value="1">
                                <label class="form-check-label inline-block text-gray-800 text-sm" for="inlineRadio20">相互フォロワーのみ</label>
                            </div>
                        </div> --}}


                        <button type="button" id="chat-create-event" class="text-white bg-red-500 border-0 py-1.5 px-6 focus:outline-none hover:bg-red-600 text-lg rounded-full w-full">作成</button>

                        <p class="text-xs text-gray-500 mt-3">※登録後24時間表示することができます</p>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="chat-create-btn chat-create-modal-open-event"></div>
    </body>
    <script>
        // 画面読み込み後実行
        $(function(){
            $('.chat-create-modal-open-event').click(function() {
                $("#chat-create-modal").fadeIn();
            })

            $('.chat-create-modal-close-event').click(function() {
                $("#chat-create-modal").fadeOut();
            })

            $('#chat-create-event').click(function() {
                if(chatValidator() === true) {
                    $('#base-form').submit();
                }
            });

            var checkInstance = '';
            $('.restrictionRadio').click(function(){
                if(checkInstance == $(this)[0]['id']) {
                    $('.restrictionRadio').prop('checked', false);
                    checkInstance = '';
                } else {
                    checkInstance = $(this)[0]['id'];
                }
            });

            const titleValidator = v8n()
                .not.null()
                .not.empty() 
                .string();
            const capacityValidator = v8n()
                .not.null()
                .not.empty()
                .between(1,10);
            const restrictionValidator = v8n()
                .not.null()
                .not.empty();

            function chatValidator() {
                let isTitleValid = titleValidator.testAll($('#title').val());
                if (isTitleValid.length !== 0) {
                    showAlertWarning('タイトルを入力してください');
                    return false;
                }

                let isCapacityValid = capacityValidator.testAll($('#capacity').val());
                if (isCapacityValid.length !== 0) {
                    showAlertWarning('募集人数を選んでください');
                    return false;
                }
                
                if($('#followers-only').prop('checked')) {
                    let isRadio1Valid = restrictionValidator.testAll($('#followers-only').val());
                    if (isRadio1Valid.length !== 0) {
                        return false;
                    }
                }
                if($('#mutual-followers-only').prop('checked')) {
                    let isRadio2Valid = restrictionValidator.testAll($('#mutual-followers-only').val());
                    if (isRadio2Valid.length !== 0) {
                        return false;
                    }
                }
                return true;
            }

            // 画面幅可変値取得
            var wid = $(window).width();
            if(wid > 640) {
                $('.chat-create-btn').addClass('hidden');
            }
            $(window).resize(function(){
                wid = $(window).width();
                if('@yield('showChatCreateBtn','true')' == 'true'){
                if(wid > 640) {
                    $('.chat-create-btn').addClass('hidden');
                }
                if(wid <= 640) {
                    $('.chat-create-btn').removeClass('hidden');
                }
                }
            });

            // スライドメニューアニメーション
            $('#user-menu-button').click(function() {
                if(wid <= 640) {
                    $('#slide-menu-bg').addClass('slide-menu-bg-open').removeClass('hidden').removeClass('slide-menu-bg-hide');
                    $('#slide-menu').addClass('slide-menu-open').removeClass('hidden').removeClass('slide-menu-hide');
                }
            })
            $('#slide-menu-close').click(function() {
                $('#slide-menu-bg').removeClass('slide-menu-bg-open').addClass('slide-menu-bg-hide');
                $('#slide-menu').removeClass('slide-menu-open').addClass('slide-menu-hide');
                window.setTimeout(function() {
                    $('#slide-menu-bg').addClass('hidden');
                    $('#slide-menu').addClass('hidden');
                }, 300)
            })

            function showAlertSuccess(text) {
                $('#alert-success').fadeIn();
                $('#alert-success-text').text(text);
                window.setTimeout(function(){
                    $('#alert-success').fadeOut();
                }, 3000)
            }

            function showAlertWarning(text) {
                $('#alert-warning').fadeIn();
                $('#alert-warning-text').text(text);
                window.setTimeout(function(){
                    $('#alert-warning').fadeOut();
                }, 3000)
            }

            function showAlertError(text) {
                $('#alert-error').fadeIn();
                $('#alert-error-text').text(text);
                window.setTimeout(function(){
                    $('#alert-error').fadeOut();
                }, 3000)
            }
            @if(Session::has('alert_succes_message'))
                showAlertSuccess('{{ session('alert_succes_message') }}');
            @endif
            @if(Session::has('alert_warning_message'))
                showAlertWarning('{{ session('alert_warning_message') }}');
            @endif
            @if(Session::has('alert_error_message'))
                showAlertError('{{ session('alert_error_message') }}');
            @endif
        });

    // チャット作成ボタン表示制御
    if('@yield('showChatCreateBtn','true')' != 'true'){
        $('.chat-create-btn').addClass('hidden');
    }
    </script>
</html>
