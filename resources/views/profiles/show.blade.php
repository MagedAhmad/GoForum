@extends('layouts.app')


@section('content')

	<div class="container">
		<div class="pb-2 mt-4 mb-2 border-bottom">
			<h1>
				{{ $profileUser->name }}
				<small>since {{ $profileUser->created_at->diffForHumans()}}</small>
			</h1>
		</div>

	    <div class="card">
            <div class="card-body">
                @foreach($threads as $thread)
                
                <article>
                    <div class="level">

                        <h3 class="flex">
                            <a href="{{$thread->path()}}">{{ $thread->title }}</a>
                        </h3>

                       
                    </div>
                    
                    <p>{{ $thread->body }}</p>
                    <hr>
                </article>
                @endforeach

            </div>
        </div>
            
	</div>



@endsection