<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name') }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Dynamic Menu -->
            @if ($headerMenu && is_array($headerMenu) && count($headerMenu) > 0)
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @foreach ($headerMenu as $item)
                        <li class="nav-item {{ !empty($item['child']) ? 'dropdown' : '' }}">
                            @if (!empty($item['child']))
                                <a class="nav-link dropdown-toggle" href="{{ $item['url'] }}" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $item['title'] }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($item['child'] as $child)
                                        <li>
                                            <a class="dropdown-item" href="{{ $child['url'] }}"
                                                target="{{ $child['target'] }}">
                                                {{ $child['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <a class="nav-link {{ request()->url() === $item['url'] ? 'active' : '' }}"
                                    href="{{ $item['url'] }}" target="{{ $item['target'] }}">
                                    {{ $item['title'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <!-- Fallback Static Menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}"
                            href="{{ route('blog') }}">Blog</a>
                    </li>
                </ul>
            @endif

            <!-- Search Form -->
            <form class="d-flex" action="{{ route('blog') }}" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search"
                    value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
