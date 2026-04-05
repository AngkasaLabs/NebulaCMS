<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'Welcome')</title>

    <!-- Meta Tags -->
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Theme Styles -->
    {!! do_action('theme.styles') !!}

    @stack('styles')
</head>

<body>
    <!-- Header -->
    <header>
        @include('theme::partials.header')
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="row">
                <!-- Content Area -->
                <div class="col-md-8">
                    <div class="content-area">
                        @yield('content')
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="sidebar">
                        @include('theme::partials.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        @include('theme::partials.footer')
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">↑</a>

    <!-- Theme Scripts -->
    {!! do_action('theme.scripts') !!}

    @stack('scripts')
</body>

</html>