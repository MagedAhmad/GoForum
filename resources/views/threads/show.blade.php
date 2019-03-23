@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="level">
                        <b class="flex">
                            <a href="{{ route('profile',$thread->user->name)}}">{{$thread->user->name }}</a> 
                            Posted {{ $thread->title }} ...

                        </b>
                        @can('update', $thread)
                        <form method="POST" action="{{$thread->path()}}">
                            {{ csrf_field()}}
                            {{ method_field('DELETE')}}
                            <button type="submit" class="btn btn-link">
                                Delete Thread
                            </button>
                        </form>
                        @endcan

                    </h5>
                </div>  

                <div class="card-body">
                    <article>
                        <p>{{ $thread->body }}</p>
                        <hr>
                        
                    </article>
                </div>
            </div>
            <br>

            
            @foreach($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links()}}

            @if(auth()->check())
                <form method="POST" action="{{$thread->path(). '/replies'}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea class="form-control" name="body" rows="5" placeholder="Have something to say?"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </div>
                </form>
            @else
            <p class="text-center">Please <a  href="{{route('login')}}">SIGN IN</a> to participate in this forum!</p>
            @endif

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>This thread was published {{$thread->created_at->diffForHumans()}} by 
                        <a href="{{ route('profile',$thread->user->name)}}">{{$thread->user->name}}</a>, and currently has {{ $thread->replies_count }} {{ str_plural('Comment', $thread->replies_count )}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <br>
    
</div>
@endsection
