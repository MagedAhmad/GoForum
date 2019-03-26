@component('profiles.activities.activity')

	@slot('title')

		<a href="{{$activity->subject->favorited->path()}}">
				Favorited a Reply 
		</a>

	@endslot

	@slot('body')

	    <p>{{ $activity->subject->favorited->body }}</p>

	@endslot

@endcomponent




