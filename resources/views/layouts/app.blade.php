<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('open-iconic-master/font/css/open-iconic-bootstrap.css') }}" rel="stylesheet">


    <script type="text/javascript">

        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'signedIn' => auth()->check(),
            'user' => auth()->user(),
        ]) !!};
        

    </script>

    <style type="text/css">
        .level {
            display:flex;
            align-items: center;
        }

        .flex {
            display:flex;
        }

        .flex-1 {
            flex:1;
        }

        .mr-1{
            margin-right:1em;
        }

        [v-cloak] {
            display: none;
        }

        .justify-between {
            justify-content: space-between;
        }

        .ml-a {
            margin-left:auto;
        }

        .card-success {
            background-color: #e6ffd9;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div id="app">
        @include('layouts.nav')

        <main class="py-4">
            @yield('content')
        </main>

        <flash message="{{ session('flash') }}"></flash>
    </div>

    @yield('scripts')
</body>
</html>
