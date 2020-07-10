    <div class="px-10 py-6 bg-gray-600 shadow-md">
<!-- <div class=" bg-teal-800 py-4 px-2"> -->
    <div class="container mx-auto">
        <nav class="flex items-center justify-between flex-wrap">
            <div class="flex items-center flex-no-shrink text-white mr-12">
                <a href="{{ url('/') }}" class="hover:no-underline hover:text-white">
                  <span class="font-black text-xl tracking-tight">Stickit</span>
                </a>
            </div>
            <div class="block sm:hidden">
                <button class="navbar-burger flex items-center px-3 py-2 border rounded text-white border-white hover:text-white hover:border-white">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                </button>
            </div>
            <div id="main-nav" class="w-full flex-grow sm:flex items-center sm:w-auto hidden  mt-2 md:mt-0">
                <div class="text-sm sm:flex-grow">
                    <a href="{{ url('/threads')}}" class="no-underline text-white font-bold block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        All Threads
                    </a>
                    @if(auth()->check())
                    <a href="{{ url('/threads/create')}}" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        Create Thread
                    </a>
                    @endif
                    <a href="{{ url('/threads?popular=1')}}" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        Popular Threads
                    </a>
                    <a href="{{ url('/threads?unanswered=1') }}" class="no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                        Unanswered Threads
                    </a>
                    
                </div>
                <div class="flex flex-col md:flex-row">
                  @if(auth()->check())
                        <notifications></notifications>
                        <a href="{{ url('/profiles/' . auth()->user()->name) }}" class="md:hidden no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4">
                            {{ auth()->user()->name }}
                        </a>
                        
                        <a class="md:hidden no-underline font-bold text-white block sm:inline-block sm:mt-0 hover:text-blue-400 mr-4" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <!-- Dropdown -->
                        <div class="hidden md:inline-block relative profile-menu">
                            <button class="block h-6 w-6 rounded-full overflow-hidden focus:outline-none">
                            <img class="h-full w-full object-cover" src="{{ auth()->user()->avatar_path }}" alt="avatar">
                            </button>
                            <!-- Dropdown Body -->
                            <div class="hidden absolute right-0 w-40 mt-2 py-2 bg-white border rounded shadow-xl">   
                                <a href="{{ url('/profiles/' . auth()->user()->name) }}" class="transition-colors duration-200 block px-4 py-2 text-normal text-gray-900 rounded hover:bg-gray-500 hover:text-white">
                                    Profile
                                </a>
                                <div class="py-2">
                                    <hr></hr>
                                </div>
                                <a href="#" class="transition-colors duration-200 block px-4 py-2 text-normal text-gray-900 rounded hover:bg-gray-500 hover:text-white"onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        <!-- // Dropdown Body -->
                        </div>
                        <!-- // Dropdown -->
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