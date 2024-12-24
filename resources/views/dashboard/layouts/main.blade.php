<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InspiraUMKM | Dashboard</title>

    @include('vendors.dashboard.css')
    @include('vendors.dashboard.js')
</head>

<body>
    @include('vendors.icons')

    @include('partials.theme')

    @include('dashboard.layouts.header')

    @yield('css');

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('container')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>

</html>
