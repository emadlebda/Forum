<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                       aria-haspopup="true"
                       aria-expanded="false">Browse <span class="caret"></span></a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{route('threads.index')}}">
                                All Threads
                            </a>
                        </li>

                        @auth
                            <li>
                                <a class="dropdown-item"
                                   href="{{route('threads.index').'?by='.auth()->user()->name}}">
                                    My Threads
                                </a>
                            </li>
                        @endauth

                        <li>
                            <a class="dropdown-item"
                               href="{{route('threads.index').'?popular=1'}}">
                                Popular Threads
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="{{route('threads.index').'?unanswered=1'}}">
                                Unanswered Threads
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('threads.create') }}">
                        {{ __('New Thread') }}
                    </a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                       aria-haspopup="true"
                       aria-expanded="false">Channels <span class="caret"></span></a>

                    <ul class="dropdown-menu">
                        @foreach ($channels as $channel)
                            <li>
                                <a class="dropdown-item" href="{{route('threads.by.channel',$channel)}}">
                                    {{ $channel->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('profile',auth()->user())}}">My Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
