<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl flex flex-col gap-3 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col gap-4">
                    @if(Session::has('success'))
                        <div class="text-green-600">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    @if(isset($posts) && $posts -> count() > 0)
                        @foreach($posts as $post)
                            <div class="mb-4">
                                @if (session('status'))
                                    <div class="" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <h1 class="text-amber-800 text-xl mb-4"> {{$post -> title}} @if(Auth::id() == $post -> user -> id) -   المالك @endif</h1>
                                {{$post -> content}}

                                @if(Auth::id() != $post -> user -> id)
                                    <form method="POST" action="{{route('saveComment')}}" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="post_id" value="{{$post -> id}}">
                                        <div class="">
                                            <input type="text"
                                                class="form-input text-gray-900 px-4 py-2 rounded"
                                                name="post_content">
                                            @error('name_ar')
                                            <small class="">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">أضافه ردك</button>
                                    </form>
                                @endif
                            </div>
                            <div class="notifications">
                                <h5>التعليقات</h5>
                                @if (count($post->comments) > 0)
                                    @foreach ($post->comments as $comment)
                                        @if (Auth::id() == $post->user -> id)
                                            <p>
                                                {{$comment->comment}}
                                            </p>
                                        @endif
                                    @endforeach
                            </div>
                                @endif
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>


            {{-- @foreach ($AllPosts as $post)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-amber-800 text-xl">{{ $post->title }}</h2>
                        <p>{{ $post->content }}</p>
                    </div>
                </div>
            @endforeach --}}
        </div>
    </div>
</x-app-layout>
