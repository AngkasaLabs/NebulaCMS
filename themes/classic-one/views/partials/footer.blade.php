<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="footer-widget">
                <h3 class="footer-widget-title">About Us</h3>
                <p>
                    {{ config('app.name') }} - A classic blog theme with a touch of nostalgia from the 2010s era.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="footer-widget">
                <h3 class="footer-widget-title">Navigation</h3>
                @if ($footerMenu)
                    <ul>
                        @foreach ($footerMenu as $item)
                            <li>
                                <a href="{{ $item['url'] }}" target="{{ $item['target'] }}">
                                    {{ $item['title'] }}
                                </a>
                                @if (!empty($item['child']))
                                    <ul>
                                        @foreach ($item['child'] as $child)
                                            <li>
                                                <a href="{{ $child['url'] }}" target="{{ $child['target'] }}">
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
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                    </ul>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="footer-widget">
                <h3 class="footer-widget-title">Connect With Us</h3>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fa fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fa fa-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</div>