@component('profiles.activities.activity')

	@slot('title')
		<div class="border-l-4 border-teal-800 px-2 bg-teal-100 py-2 text-teal-800 w-full mb-4">

			Replied to 
			<a href="{{$activity->subject->thread->path()}}">
			    {{ $activity->subject->thread->title }}
			</a>
		</div>
	@endslot

	@slot('body')

	    <p>{!! $activity->subject->body !!}</p>

	@endslot

@endcomponent




