<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Stickit is a modern forum software for developers. Making it easy to engage in focused programming related discussion">
    <meta name="keywords" content="Discussion, Question, Programming, Developers, Code">
    <meta name="author" content="Maged Raslan">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Stickit @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('open-iconic-master/font/css/open-iconic-bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript">
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'signedIn' => auth()->check(),
            'user' => auth()->user(),
        ]) !!};
    </script>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
      .profile-menu:hover > div {
        display:inline-block;
      }
    </style>
    @yield('styles')
</head>
<body>
    <div id="app">
        @include('layouts.nav')

        <main class="mb-4">
            @yield('content')
        </main>

        <flash message="{{ session('flash') }}"></flash>
    </div>
    @yield('scripts')

    <script type="text/javascript">
        // Navbar Toggle
        document.addEventListener('DOMContentLoaded', function () {

      // Get all "navbar-burger" elements
      var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

      // Check if there are any navbar burgers
      if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(function ($el) {
          $el.addEventListener('click', function () {

            // Get the "main-nav" element
            var $target = document.getElementById('main-nav');

            // Toggle the class on "main-nav"
            $target.classList.toggle('hidden');

          });
        });
      }

        });
    </script>
</body>
</html>
