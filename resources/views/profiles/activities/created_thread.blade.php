@component('profiles.activities.activity')

	@slot('title')

		<div class="border-l-4 border-gray-800 px-2 bg-gray-100 py-2 text-gray-800 w-full mb-4">
			Posted
			<a href="{{$activity->subject->path()}}">{{ $activity->subject->title }}</a>
        </div>

	@endslot

	@slot('body')

	    <p>{!! $activity->subject->body !!}</p>

	@endslot

@endcomponent


