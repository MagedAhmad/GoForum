@component('profiles.activities.activity')

	@slot('title')
		<div class="border-l-4 border-gray-800 px-2 bg-gray-100 py-2 text-gray-800 w-full mb-4">

			<a href="{{$activity->subject->favorited->path()}}">
					Favorited a Reply 
			</a>
		</div>
	@endslot

	@slot('body')

	    <p>{{ $activity->subject->favorited->body }}</p>

	@endslot

@endcomponent




