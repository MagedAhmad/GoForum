@extends('layouts.app')

@section('title')
    - {{ "Threads" }}
@endsection

@section('content')
<div class="container mx-2">
    <div class="row w-full flex flex-col justify-center">
        <div class="mt-4 px-2 divide-x divide-gray-400">
            <nav class="px-8 pt-2">
                <div class="flex justify-center flex-wrap">
                @foreach($channels as $channel)
                    <a class="no-underline hover:no-underline text-teal-dark border-b-2 border-teal-dark hover:border-red-500 uppercase tracking-wide text-gray-700 font-bold hover:text-gray-600 mr-4" href="{{ url('/threads/' . $channel->slug) }}">
                        {{ $channel->name}}
                    </a>
                @endforeach
                    
                </div>
            </nav>
        </div>
        <div class="flex items-center flex-col">
            @include('threads._list')
            <div style="margin:0 auto">
                {{ $threads->render() }}
            </div>
        </div>
    </div>
</div>
@endsection
