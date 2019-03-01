@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum</div>

                <div class="card-body">
                    <article>
                    @foreach($threads as $thread)

                        <h3><a href="{{$thread->path()}}">{{ $thread->title }}</a></h3>
                        <p>{{ $thread->body }}</p>
                        <hr>
                    @endforeach
                    </article>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
