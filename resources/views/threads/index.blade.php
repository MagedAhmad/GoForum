@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  my-8">

        <div class="col-md-8">
            
                @include('threads._list')
                
                <div style="margin:0 auto">
                    {{ $threads->render() }}
                </div>

        </div>
        @if($trending)
        <div class="col-md-4">
        	<div class="card">
        		<div class="card-header bg-teal-800 text-white mb-2">Trending Threads</div>
			    <div class="card-body">
			        <ul class="list-group">
			        	@foreach($trending as $thread)
							<li class="list-group-item"><a href="{{$thread->path}}">{{$thread->title}}</a></li>
					  	@endforeach
					</ul>
			    </div>
			</div>
            <div class="card">
                <div class="card-header bg-teal-800 text-white mb-2">Channels</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($channels as $channel)
                            <li class="list-group-item"><a href="/threads/{{$channel->slug}}">{{$channel->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>	
        @endif

        
    </div>
</div>
@endsection
