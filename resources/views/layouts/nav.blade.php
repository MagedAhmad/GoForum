    <div class="px-10 py-6 bg-gray-600 shadow-md">
<!-- <div class=" bg-teal-800 py-4 px-2"> -->
    <div class="container mx-auto">
        <nav class="flex items-center justify-between flex-wrap">
            <div class="flex items-center flex-no-shrink text-white mr-12">
                <a href="/" class=" hover:no-underline">
                  <span class="font-semibold text-xl tracking-tight">TWiNKY</span>
                </a>
            </div>
            <div class="block sm:hidden">
                <button class="navbar-burger flex items-center px-3 py-2 border rounded text-white border-white hover:text-white hover:border-white">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                </button>
            </div>
            <div id="main-nav" class="w-full flex-grow sm:flex items-center sm:w-auto hidden  mt-2 md:mt-0">
                <div class="text-sm sm:flex-grow">
                    <a href="/threads" class="no-underline text-white font-bold block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        All Threads
                    </a>
                    @if(auth()->check())
                    <a href="/threads/create" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        Create Thread
                    </a>
                    @endif
                    <a href="/threads?popular=1" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        Popular Threads
                    </a>
                    <a href="/threads?unanswered=1" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        Unanswered Threads
                    </a>
                    
                </div>
                <div class="flex flex-col md:flex-row">
                  @if(auth()->check())
                        <notifications></notifications>
                        <a href="/profiles/{{ auth()->user()->name }}" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">{{ auth()->user()->name }}</a>
                        
                            <a class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                  @else
                    <a href="{{route('login')}}" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        login
                    </a>
                    <a href="{{route('register')}}" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        Register
                    </a>
                  @endif
                </div>
            </div>
        </nav>
    </div>
</div>