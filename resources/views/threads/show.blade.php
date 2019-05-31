@extends('layouts.app')

@section('styles')

<link rel="stylesheet" type="text/css" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<div class="container">
    <thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="level">
                            <b class="flex">
                                <img src="{{$thread->user->avatar_path}}" width="25" height="25">
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

                <replies 
                    @added="repliesCount++"
                    @removed="repliesCount--"></replies>




            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>This thread was published {{$thread->created_at->diffForHumans()}} by 
                            <a href="{{ route('profile',$thread->user->name)}}">{{$thread->user->name}}</a>, and currently has <span v-text="repliesCount"></span> {{ str_plural('Comment', $thread->replies_count )}}
                        </p>

                        <subscripe-button :active="{{ json_encode($thread->is_subscriped_to) }}"></subscripe-button>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
    <br>
    
</div>
@endsection
