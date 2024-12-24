<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>InspiraUMKM | {{ $title }}</title>

    @include('vendors.main.css')
    @include('vendors.main.js')
</head>

<body>
    @include('vendors.icons')

    @include('partials.theme')

    @include('partials.navbar')

    @yield('css')

    <div class="content container-fluid px-0" style="min-height: 100vh;">
        @yield('container')
    </div>

    @include('partials.footer')

    @yield('scripts')
</body>

</html>
