@extends('layouts.app')

@section('styles')

<link rel="stylesheet" type="text/css" href="/css/vendor/jquery.atwho.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css">


@endsection

@section('content')
<div class="container">
    <thread-view inline-template  :thread="{{ $thread }}">
        <div class="row">
            <div class="col-md-8">
                <div v-cloak>
                    @include('threads._topic')
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

                        <subscripe-button :active="{{ json_encode($thread->is_subscriped_to) }}" v-if="signedIn"></subscripe-button>
                        <button class="btn btn-danger" @click="toggleLock" v-if="authorize('isAdmin')" v-text="locked ? 'Unlock' : 'Lock'"></button>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
    <br>
    
</div>
@endsection
