    <!-- Edit thread -->
    
    <div v-if="editing">
        <div class="max-w-4xl px-10 my-4 py-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center">
                <span class="font-light text-gray-600">{{ $thread->created_at->diffForHumans()}} - {{ $thread->visits() }} Visits</span>
                @can('update', $thread)
                    <form method="POST" action="{{$thread->path()}}">
                    {{ csrf_field()}}
                    {{ method_field('DELETE')}}
                        <button type="submit" class="px-2 py-1 bg-gray-600 text-gray-100 font-bold rounded hover:bg-gray-500 hover:text-gray-100 hover:no-underline" href="#">Delete</button>
                    </form>
                @endcan
            </div>
            <div class="mt-2">
                <input type="text" class="text-2xl text-gray-700 font-bold hover:text-gray-600" v-model="form.title">
                <wysiwyg class="mt-2 text-gray-600"  name="body" v-model="form.body"></wysiwyg>
            </div>
            
            <button class="mt-6 mb-12 md:mb-0 md:mt-10 inline-block py-2 px-8 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow" @click="update">Update</button>
            <button class="px-2 py-1 bg-black text-gray-100 font-bold rounded hover:bg-gray-500 hover:text-gray-100 hover:no-underline" @click="reset">Cancel</button>
        </div>
    </div>

<!-- View the thread -->
<div v-if="! editing">
    <div class="max-w-4xl px-10 mb-4 py-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <span class="font-light text-gray-600">{{ $thread->created_at->diffForHumans()}} - {{ $thread->visits() }} Visits</span>

            @can('update', $thread)
            <a @click="editing = true" class="px-2 py-1 bg-gray-600 text-gray-100 font-bold rounded hover:bg-gray-500 hover:text-gray-100 hover:no-underline" href="#">Edit</a>
            @endcan
        </div>
        <div class="mt-2">
            <span class="text-2xl text-gray-700 font-bold hover:text-gray-600" href="{{$thread->path()}}" v-text="this.title"></span>
            <p class="mt-2 text-gray-600" v-html="this.body"></p>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-center mt-4">
            <div class="mt-4 flex items-center ">
                
                <div class="flex mr-2 text-gray-700 text-sm mr-8">
                    <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                    </svg>
                    <span>{{$thread->replies_count}}</span>
                </div>
                <div class="flex mr-2 text-gray-700 text-sm mr-4">
                    <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span>share</span>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <a class="flex items-center" href="{{ url('/profiles/' . $thread->user->name) }}">
                    <img class="mx-4 w-10 h-10 object-cover rounded-full hidden sm:block" src="{{$thread->user->avatar_path}}" alt="avatar">
                    <h1 class="text-gray-700 font-bold">{{ $thread->user->name }} ({{ $thread->user->reputation .' XP' }})</h1>
                </a>
            </div>
        </div>
        
    </div>



















</div>