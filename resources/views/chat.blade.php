@extends('base')

@section('title',session('name') . 'のつのりた')

@section('showChatCreateBtn','false')

@section('content')
<div class="flex h-screen antialiased text-gray-800">
    <div class="flex flex-row h-full w-full overflow-x-hidden">
      <div class="flex flex-col flex-auto h-full">
        <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-base-100 h-full pb-16 px-2 pt-16">
          <div id="scroll" class="flex flex-col h-full overflow-x-hidden">
            <div class="flex flex-col h-full">
              <div id="chat-area" class="grid grid-cols-12 gap-y-2 pb-4">

                @foreach($commentList as $comment)
                @if($comment->twitter_id === session('twitter_id'))
                  <div class="col-start-1 col-end-13 p-2.5 rounded-lg">
                    <div class="flex items-center justify-start flex-row-reverse">
                      <img class="h-10 w-10 rounded-full" src="{{ $comment->avatar }}" alt="プロフィール">
                      <div class="relative mr-3 text-sm bg-white py-2 px-3 shadow rounded-xl">
                        <div><span>{{ $comment->comment }}</span></div>
                        <div class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500 whitespace-nowrap">{{ $comment->name}}</div>
                      </div>
                    </div>
                  </div>
                @else
                  <div class="col-start-1 col-end-13 p-2.5 rounded-lg">
                    <div class="flex flex-row items-center">
                      <img class="h-10 w-10 rounded-full" src="{{ $comment->avatar }}" alt="プロフィール">
                      <div class="relative ml-3 text-sm bg-indigo-100 py-2 px-3 shadow rounded-xl">
                        <div><span>{{ $comment->comment }}</span></div>
                        <div class="absolute text-xs bottom-0 left-0 -mb-5 mr-2 text-gray-500 whitespace-nowrap">{{ $comment->name}}</div>
                      </div>
                    </div>
                  </div>
                @endif
                @endforeach

              </div>
            </div>
          </div>
       
          <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full pr-4 pl-3 z-10" style="position: fixed; bottom: 4px;">
            <div class="chat-info-modal-open-event">
              <svg class="w-6 h-6 mr-1 cursor-pointer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve">
              <g>
                <path class="st0" d="M437.015,74.978C390.77,28.696,326.608-0.014,256,0C185.393-0.014,121.223,28.696,74.982,74.978
                  C28.696,121.223-0.014,185.393,0,256c-0.014,70.608,28.696,134.778,74.982,181.023C121.226,483.304,185.393,512.015,256,512
                  c70.608,0.015,134.77-28.696,181.015-74.977c46.288-46.245,75-110.415,74.985-181.023
                  C512.015,185.393,483.304,121.223,437.015,74.978z M399.474,112.526c36.756,36.8,59.415,87.356,59.429,143.474
                  c-0.014,56.119-22.674,106.674-59.429,143.474c-36.8,36.762-87.363,59.415-143.474,59.429
                  c-56.114-0.014-106.674-22.667-143.474-59.429c-36.76-36.8-59.415-87.355-59.43-143.474c0.015-56.118,22.67-106.674,59.43-143.474
                  c36.8-36.763,87.359-59.415,143.474-59.43C312.112,53.112,362.674,75.763,399.474,112.526z" style="fill: rgb(75, 75, 75);"></path>
                <path class="st0" d="M242.749,329.326c-14.208,0-25.73,11.519-25.73,25.726c0,14.192,11.522,25.718,25.73,25.718
                  c14.196,0,25.714-11.526,25.714-25.718C268.463,340.845,256.945,329.326,242.749,329.326z" style="fill: rgb(75, 75, 75);"></path>
                <path class="st0" d="M184.363,173.852l17.515,14.037c3.566,2.852,8.674,2.748,12.118-0.252c0,0,2.152-3.889,8.896-7.741
                  c6.778-3.83,15.57-6.911,28.708-6.956c11.462-0.022,21.459,4.252,28.278,10.097c3.385,2.904,5.918,6.133,7.47,9.11
                  c1.563,2.986,2.133,5.6,2.126,7.585c-0.03,6.711-1.337,11.104-3.222,14.837c-1.433,2.8-3.303,5.274-5.715,7.674
                  c-3.596,3.6-8.482,6.926-13.955,9.985c-5.482,3.082-11.389,5.808-17.359,9.096c-6.808,3.778-14.022,9.194-19.345,17.326
                  c-2.659,4.015-4.737,8.622-6.059,13.466c-1.334,4.867-1.937,9.956-1.937,15.148c0,5.541,0,10.096,0,10.096
                  c0,5.215,4.237,9.46,9.463,9.46h22.788c5.222,0,9.456-4.245,9.456-9.46c0,0,0-4.555,0-10.096c0-2,0.23-3.296,0.452-4.104
                  c0.374-1.229,0.585-1.534,1.208-2.282c0.626-0.711,1.896-1.792,4.237-3.088c3.419-1.919,8.915-4.512,15.141-7.882
                  c9.322-5.096,20.648-12.007,30.204-23.422c4.748-5.703,8.948-12.556,11.86-20.452c2.918-7.904,4.503-16.792,4.489-26.304
                  c-0.008-9.637-2.622-18.8-6.882-26.926c-6.415-12.207-16.467-22.37-28.919-29.748c-12.448-7.341-27.47-11.822-43.777-11.822
                  c-20.097-0.052-36.797,5.192-49.396,12.444c-12.656,7.222-18.111,15.629-18.111,15.629c-2.126,1.852-3.326,4.534-3.278,7.341
                  C180.878,169.467,182.17,172.104,184.363,173.852z" style="fill: rgb(75, 75, 75);"></path>
              </g>
              </svg>
            </div>
            {{-- <div>
              <button
                class="flex items-center justify-center text-gray-400 hover:text-gray-600"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
                  ></path>
                </svg>
              </button>
            </div> --}}
            <div class="flex-grow">
              <div class="relative w-full">
                <input id="comment" type="text" name="comment" class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10"/>
                <button class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600">
                  {{-- <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg> --}}
                </button>
              </div>
            </div>

            <div class="ml-4">
              <button id="comment-send-event" type="submit" class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 md:py-2 py-2.5 flex-shrink-0">
                {{-- <span class="md:text-base text-xs">送信</span> --}}
                <span class="ml-2">
                  <svg class="w-5 h-5 transform rotate-45 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                  </svg>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="chat-info-modal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 z-10">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity chat-info-modal-close-event"></div>
      <div class="flex min-h-full justify-center p-4 text-center items-center sm:p-0">
          <div class="flex flex-wrap w-full mt-4 flex-col items-center text-center">
              <div class="shadow-lg rounded-2xl w-72 bg-white dark:bg-gray-800 p-4 z-10 relative">
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
                      {{-- @if($chat->followers_only_flag == true)
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
                      @endif --}}
                      <a href="https://twitter.com/share?url={{ route('chat.preview', $chat->unique_key) }}" rel="nofollow noopener">
                      <li class="mb-3 flex items-center ">
                          <img class="h-6 w-6 mr-2 rounded-full bg-white border-white" src="{{ asset('image/twitter.jpeg') }}" alt="プロフィール">
                          ツイートする
                      </li>
                    </a>
                  </ul>
                @if($chat->user_id == session('user_id'))

                <form id="chat-form" action="{{ route('chat.delete') }}" method="post">
                        @csrf
                    <input id="chat-id" type="hidden" name="chat_id" value="{{ $chat->chat_id }}">
                </form>
                <a href="#" class="text-red-600 delete-event">募集を削除する</a>
                @else

                <form id="chat-form" action="{{ route('chat.leaving') }}" method="post">
                        @csrf
                    <input id="chat-id" type="hidden" name="chat_id" value="{{ $chat->chat_id }}">
                </form>
                <a href="#" class="text-red-600 leaving-event">退出する</a>
                @endif
              </div>
          </div>
      </div>
    </div>
  </div>

  <script>

    @if(isset($chat->chat_id))
    $(function(){
      // TODO:更新されたコメントのみDOM追加するようにする？？
      var offset = 0;

      var commentDataCount = 0;

      $('#comment-send-event').click(function() {
        
        if($('#comment').val() != '') {
            const postData = {
            'chat_id': '{{ $chat->chat_id }}',
            'comment': $('#comment').val()
          };
          $('#comment').val('')
          $.ajax({
            type: "POST",
            url: '{{ route('comment.create') }}',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
          }).done(function( data ) {
            $('#chat-area').empty();
            let append = '';
            $.each(data,function(index,value){
              if(value['twitter_id'] === '{{ session('twitter_id') }}') {
                append = 
                  `<div class="col-start-1 col-end-13 p-2.5 rounded-lg">
                    <div class="flex items-center justify-start flex-row-reverse">
                      <img class="h-10 w-10 rounded-full" src="${ value['avatar'] }" alt="プロフィール">
                      <div class="relative mr-3 text-sm bg-white py-2 px-3 shadow rounded-xl">
                        <div class="whitespace-pre-wrap">${ value['comment'] }</div>
                        <div class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500 whitespace-nowrap">${ value['name'] }</div>
                      </div>
                    </div>
                  </div>`;
              } else {
                append = 
                  `<div class="col-start-1 col-end-13 p-2.5 rounded-lg">
                    <div class="flex flex-row items-center">
                      <img class="h-10 w-10 rounded-full" src="${ value['avatar'] }" alt="プロフィール">
                      <div class="relative ml-3 text-sm bg-indigo-100 py-2 px-3 shadow rounded-xl">
                        <div class="whitespace-pre-wrap">${ value['comment'] }</div>
                        <div class="absolute text-xs bottom-0 left-0 -mb-5 mr-2 text-gray-500 whitespace-nowrap">${ value['name'] }</div>
                      </div>
                    </div>
                  </div>`;
              }
              $('#chat-area').append(append);
            })
            var objDiv = document.getElementById("scroll");
            objDiv.scrollTop = objDiv.scrollHeight;
            // $('#scroll').animate({scrollTop:objDiv.scrollHeight});
          }).fail(function(){
            console.log('fail');
          });
        }         
      });

      function chatUpdate() {
        if(document.hasFocus()) { //画面アクティブ中のみ更新
          $.ajax({
            type: "POST",
            url: '{{ route('comment.update') }}',
            data: JSON.stringify({'chat_id': '{{ $chat->chat_id }}'}),
            contentType: 'application/json',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
          }).done(function( data ) {
            $('#chat-area').empty();
            let append = '';
            $.each(data,function(index,value){
              if(value['twitter_id'] === '{{ session('twitter_id') }}') {
                append = 
                  `<div class="col-start-1 col-end-13 p-2.5 rounded-lg">
                    <div class="flex items-center justify-start flex-row-reverse">
                      <img class="h-10 w-10 rounded-full" src="${ value['avatar'] }" alt="プロフィール">
                      <div class="relative mr-3 text-sm bg-white py-2 px-3 shadow rounded-xl">
                        <div class="whitespace-pre-wrap">${ value['comment'] }</div>
                        <div class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500 whitespace-nowrap">${ value['name'] }</div>
                      </div>
                    </div>
                  </div>`;
              } else {
                append = 
                  `<div class="col-start-1 col-end-13 p-2.5 rounded-lg">
                    <div class="flex flex-row items-center">
                      <img class="h-10 w-10 rounded-full" src="${ value['avatar'] }" alt="プロフィール">
                      <div class="relative ml-3 text-sm bg-indigo-100 py-2 px-3 shadow rounded-xl">
                        <div class="whitespace-pre-wrap">${ value['comment'] }</div>
                        <div class="absolute text-xs bottom-0 left-0 -mb-5 mr-2 text-gray-500 whitespace-nowrap">${ value['name'] }</div>
                      </div>
                    </div>
                  </div>`;
              }
              $('#chat-area').append(append);
            })
            if(data.length != commentDataCount) {
              var objDiv = document.getElementById("scroll");
              objDiv.scrollTop = objDiv.scrollHeight;
              // $('#scroll').animate({scrollTop:objDiv.scrollHeight});
              commentDataCount = data.length;
            } 
            // console.log(data);
          }).fail(function(){
            console.log('fail');
          });
        }
        // setTimeout(function() {chatUpdate()},1000); //このやり方でループすると重い？？
      }

      // 初期処理
      // chatUpdate();
      setInterval(function() {chatUpdate()},2000);
      var objDiv = document.getElementById("scroll");
      objDiv.scrollTop = objDiv.scrollHeight;
    })
    @endif

    $('.chat-info-modal-open-event').click(function() {
        $("#chat-info-modal").fadeIn();
    })
    $('.chat-info-modal-close-event').click(function() {
        $("#chat-info-modal").fadeOut();
    })

    $('.delete-event').click(function() {
        if(window.confirm('{{ $chat->title }}を消しますか？')) {
            $('#chat-form').submit();
            return false;
        }
    })

    $('.leaving-event').click(function() {
        if(window.confirm('{{ $chat->title }}を退出しますか？')) {
            $('#chat-form').submit();
            return false;
        }
    })
  </script>
@endsection