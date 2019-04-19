@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Threads</div>


                @forelse($threads as $thread)

                <div class="card-body">
                    <article>
                        <div class="level">

                            <h3 class="flex">
                                @if($thread->hasUpdatesFor())
                                    <strong>
                                        <a href="{{$thread->path()}}">{{ $thread->title }}</a>
                                    </strong>
                                @else
                                    <a href="{{$thread->path()}}">{{ $thread->title }}</a>

                                @endif
                            </h3>

                            <strong>{{$thread->replies_count}} {{str_plural('Reply', $thread->replies_count)}}</strong>
                        </div>
                        
                        <p>{{ $thread->body }}</p>
                        <hr>
                    </article>
                </div>
                @empty

                <h4 style="margin:20px" class="text-center">No threads are available yet !</h4>
                @endforelse

            </div>
        </div>
    </div>
</div>
@endsection
