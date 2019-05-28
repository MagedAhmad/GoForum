<div class="card-header">All Threads</div>

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
                            <a href="{{$thread->path()}}">{{ $thread->title }}</a>

                        @endif
                    </h3>
                    <h5>by <a href="{{route('profile', $thread->user)}}">{{$thread->user->name }}</a></h5>
                </div>
                <strong>{{$thread->replies_count}} {{str_plural('Reply', $thread->replies_count)}}</strong>
            </div>
            
            <p>{{ $thread->body }}</p>
            <hr>
        </article>
    </div>
@empty
</div>
<h4 style="margin:20px" class="text-center">No threads are available yet !</h4>
@endforelse