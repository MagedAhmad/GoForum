<div class="card-header  bg-teal-800 text-white mb-2">All Threads</div>

@forelse($threads as $thread)
<div class="card">

    <div class="card-body">
        <article>
            <div class="flex justify-between">
                <div>
                    <h3>
                        @if(auth()->check() && $thread->hasUpdatesFor())
                            <strong>
                                <a href="{{$thread->path()}}">{{ $thread->title }}</a>
                            </strong>
                        @else
                            <a  class=" bg-teal-800 text-white" href="{{$thread->path()}}">{{ $thread->title }}</a>

                        @endif
                    </h3>
                    <h5>by <a href="{{route('profile', $thread->user)}}">{{$thread->user->name }}</a></h5>
                </div>
                <strong>{{$thread->replies_count}} {{Illuminate\Support\Str::plural('Reply', $thread->replies_count)}}</strong>
            </div>
            
            <p>{!! $thread->body !!}</p>
            <hr>
        </article>
    </div>
    <div class="card-footer  bg-teal-800 text-white">
        {{ $thread->visits() }} Visits
    </div>
</div>
<br>
@empty

<h4 style="margin:20px" class="text-center">No threads are available yet !</h4>
@endforelse