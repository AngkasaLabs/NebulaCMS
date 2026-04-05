<header class="site-header">
    <div class="container">
        <div class="site-branding">
            <h1 class="site-title"><a href="{{ route('home') }}">{{ config('app.name') }}</a></h1>
            <p class="site-description">A Classic Blog Theme</p>
        </div>
    </div>
</header>

<nav class="main-navigation">
    <div class="container">
        <!-- Dynamic Menu -->
        @if ($headerMenu && is_array($headerMenu) && count($headerMenu) > 0)
            <ul>
                @foreach ($headerMenu as $item)
                    <li class="{{ !empty($item['child']) ? 'menu-item-has-children' : '' }} {{ request()->url() === $item['url'] ? 'active' : '' }}">
                        <a href="{{ $item['url'] }}" target="{{ $item['target'] }}">{{ $item['title'] }}</a>
                        @if (!empty($item['child']))
                            <ul class="dropdown-menu">
                                @foreach ($item['child'] as $child)
                                    <li>
                                        <a href="{{ $child['url'] }}" target="{{ $child['target'] }}">{{ $child['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <!-- Fallback Static Menu -->
            <ul>
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="{{ request()->routeIs('blog*') ? 'active' : '' }}">
                    <a href="{{ route('blog') }}">Blog</a>
                </li>
            </ul>
        @endif

        <!-- Search Form -->
        <form class="search-form" action="{{ route('blog') }}" method="GET">
            <input type="search" name="search" placeholder="Search..." value="{{ request('search') }}">
            <button type="submit"><i class="fa fa-search"></i> Search</button>
        </form>
    </div>
</nav>