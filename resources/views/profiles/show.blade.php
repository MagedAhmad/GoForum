@extends('layouts.app')

@section('title')
    - {{ $profileUser->name }}
@endsection

@section('content')

	<div class="container mx-auto md:w-3/5">
		<div class="pb-2 mt-4 mb-2 border-bottom">
            <avatar-form :user="{{ $profileUser }}"></avatar-form>
		</div>

        @forelse($activities as $date => $activity)
        	<br>
	    	<h4 class="page-header">{{ $date }}</h4>
        	<br>
	    	
            @foreach($activity as $record)
            	@if(view()->exists("profiles.activities.{$record->type}"))
                	@include("profiles.activities.{$record->type}", ['activity' => $record])
                @endif
            @endforeach
        @empty
        	<p>There is no activity for this user yet!</p>         
        @endforelse

            
	</div>

</div>


@endsection