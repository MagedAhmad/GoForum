@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="#">{{$thread->user->name }} </a>Posted:   {{ $thread->title}}</div>

                <div class="card-body">
                    <article>
                        <p>{{ $thread->body }}</p>
                        <hr>
                        
                    </article>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">

        @foreach($thread->replies as $reply)
            @include('threads.reply')

        @endforeach
    </div>
    <br>
    @if(auth()->check())
    <div class="row justify-content-center">
        <form method="POST" action="{{$thread->path(). '/replies'}}">
            {{ csrf_field() }}
            <div class="form-group">
                                
                <textarea class="form-control" name="body" rows="5" placeholder="Have something to say?"></textarea>

                <input type="submit" name="submit" value="Submit">
            </div>
        </form>
    </div>
    @else
    <p class="text-center">Please <a href="{{route('login')}}">SIGN IN</a> to participate in this forum!</p>
    @endif
</div>
@endsection
