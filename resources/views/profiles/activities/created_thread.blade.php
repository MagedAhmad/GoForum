@component('profiles.activities.activity')

	@slot('title')

		Posted 
		<a href="{{$activity->subject->path()}}">{{ $activity->subject->title }}</a>

	@endslot

	@slot('body')

	    <p>{{ $activity->subject->body }}</p>

	@endslot

@endcomponent


