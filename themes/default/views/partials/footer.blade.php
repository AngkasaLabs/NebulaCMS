<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
            <h5>About Us</h5>
            <p class="text-muted">
                {{ config('app.name') }} - Modern content platform built with Laravel and React.
            </p>
        </div>

        <div class="col-md-4 mb-4 mb-md-0">
            @if ($footerMenu)
                <ul class="list-unstyled">
                    @foreach ($footerMenu as $item)
                        <li class="mb-2">
                            <a href="{{ $item['url'] }}" class="text-decoration-none" target="{{ $item['target'] }}">
                                {{ $item['title'] }}
                            </a>
                            @if (!empty($item['child']))
                                <ul class="list-unstyled ms-3 mt-1">
                                    @foreach ($item['child'] as $child)
                                        <li class="mb-1">
                                            <a href="{{ $child['url'] }}" class="text-decoration-none text-muted"
                                                target="{{ $child['target'] }}">
                                                {{ $child['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <!-- Fallback Static Menu -->
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li><a href="{{ route('blog') }}" class="text-decoration-none">Blog</a></li>
                </ul>
            @endif
        </div>
    </div>

    <hr class="my-4">

    <div class="text-center">
        <p class="mb-0">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</div>
