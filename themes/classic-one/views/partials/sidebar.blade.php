<!-- Search Widget -->
<div class="sidebar-widget">
    <h3 class="sidebar-widget-title">Search</h3>
    <form action="{{ route('blog') }}" method="GET" class="search-form">
        <input type="search" name="search" placeholder="Search..." value="{{ request('search') }}">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
</div>

<!-- Categories Widget -->
<div class="sidebar-widget">
    <h3 class="sidebar-widget-title">Categories</h3>
    <ul>
        @foreach ($categories ?? [] as $category)
            <li>
                <a href="{{ route('blog', ['category' => $category->slug]) }}">
                    {{ $category->name }}
                    <span class="post-count">({{ $category->posts_count }})</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<!-- Tags Widget -->
<div class="sidebar-widget">
    <h3 class="sidebar-widget-title">Tags</h3>
    <div class="tags">
        @foreach ($tags ?? [] as $tag)
            <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="tag-link">
                {{ $tag->name }} ({{ $tag->posts_count }})
            </a>
        @endforeach
    </div>
</div>

<!-- Popular Posts Widget -->
@if(isset($popular_posts) && count($popular_posts) > 0)
<div class="sidebar-widget">
    <h3 class="sidebar-widget-title">Popular Posts</h3>
    <ul>
        @foreach ($popular_posts as $popularPost)
            <li>
                <a href="{{ route('blog.post', $popularPost->slug) }}">
                    {{ $popularPost->title }}
                </a>
                <span class="post-views"><i class="fa fa-eye"></i> {{ $popularPost->views }} views</span>
            </li>
        @endforeach
    </ul>
</div>
@endif

<!-- Recent Posts Widget -->
<div class="sidebar-widget">
    <h3 class="sidebar-widget-title">Recent Posts</h3>
    <ul>
        @foreach ($recentPosts ?? [] as $recentPost)
            <li>
                <a href="{{ route('blog.post', $recentPost->slug) }}">
                    {{ $recentPost->title }}
                </a>
                <span class="post-date">{{ $recentPost->published_at->format('M d, Y') }}</span>
            </li>
        @endforeach
    </ul>
</div>

<!-- About Widget -->
<div class="sidebar-widget">
    <h3 class="sidebar-widget-title">About</h3>
    <p>Welcome to our classic blog theme. This sidebar is perfect for showcasing important information and navigation elements.</p>
</div>