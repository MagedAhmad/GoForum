@forelse($threads as $thread)

<div>
    <div class="thread-card max-w-4xl px-10 my-4 py-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <span class="font-light text-gray-600">{{ $thread->created_at->diffForHumans()}} - {{ $thread->visits() }} Visits</span>
            <div>
                @if(auth()->check() && $thread->hasUpdatesFor())
                <a class="px-2 py-1 bg-gray-600 text-gray-100 font-bold rounded hover:bg-gray-500 hover:text-gray-100 hover:no-underline" href="#">Updated ..</a>
                @endif
                <a class="px-2 py-1 bg-red-500 text-white font-bold rounded hover:bg-gray-500 hover:text-gray-100 hover:no-underline" href="{{ url('/threads/' . $channel->slug) }}">{{ $thread->channel->name }}</a>
            </div>
        </div>
        <div class="mt-2">
            <a class="text-2xl text-gray-700 font-bold hover:text-gray-600" href="{{$thread->path()}}">{{ $thread->title }}</a>
            <p class="mt-2 text-gray-600">{!! Illuminate\Support\Str::words($thread->body,30) !!}</p>
        </div>
        <div class="flex justify-between items-center mt-4">
            <a class="text-blue-600 hover:underline" href="{{$thread->path()}}">Read more ..</a>
            <div>
                <a class="flex items-center" href="{{ url('/profiles/' . $thread->user->name) }}">
                    <img class="mx-4 w-10 h-10 object-cover rounded-full hidden sm:block" src="{{$thread->user->avatar_path}}" alt="avatar">
                    <h1 class="text-gray-700 font-bold">{{ $thread->user->name }} ({{ $thread->user->reputation .' XP' }})</h1>
                </a>
            </div>
        </div>
        <div class="mt-4 flex items-center">
            <!-- <div class="flex mr-2 text-gray-700 text-sm mr-3">
                <svg fill="none" viewBox="0 0 24 24"  class="w-4 h-4 mr-1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span>{{ $thread->favorites_count }}</span>
            </div> -->
            <div class="flex mr-2 text-gray-700 text-sm mr-8">
                <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
                <span>{{$thread->replies_count}}</span>
            </div>
            <div class="flex mr-2 text-gray-700 text-sm mr-4">
                <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span>share</span>
            </div>
        </div>
    </div>
</div>

@empty

<div>
    <h4 class=" my-16 text-center text-lg">No threads are available yet! <br> 
    Check back later or even start by <a class="text-blue-500" href="{{url('/threads/create')}}">writing your own Thread</a> on this topic!</h4>
</div>
@endforelse