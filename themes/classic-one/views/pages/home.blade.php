@extends('theme::layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to {{ config('app.name') }}</h1>
        <p class="lead">A classic blog platform with a touch of nostalgia</p>
    </div>

    <!-- Latest Posts Section -->
    <section class="latest-posts">
        <h2 class="section-title">Latest Posts</h2>

        @foreach ($posts as $post)
            <article class="post">
                @if ($post->featured_image_url)
                    <div class="post-thumbnail">
                        <a href="{{ route('blog.post', $post->slug) }}">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}">
                        </a>
                    </div>
                @endif

                <h3 class="post-title">
                    <a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a>
                </h3>

                <div class="post-meta">
                    <span class="post-date"><i class="fa fa-calendar"></i> {{ $post->published_at->format('M d, Y') }}</span>
                    
                    @if ($post->category)
                        <span class="post-category">
                            <i class="fa fa-folder"></i>
                            <a href="{{ route('blog', ['category' => $post->category->slug]) }}">
                                {{ $post->category->name }}
                            </a>
                        </span>
                    @endif
                </div>

                <div class="post-content">
                    {{ Str::limit(strip_tags($post->content), 200) }}
                </div>

                <a href="{{ route('blog.post', $post->slug) }}" class="read-more">Read More</a>
            </article>
        @endforeach
    </section>

    <!-- Categories & Tags Section -->
    <div class="row">
        <!-- Categories -->
        <div class="col-md-6">
            <div class="home-widget">
                <h3 class="widget-title">Categories</h3>
                <ul class="category-list">
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('blog', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                                <span class="post-count">({{ $category->posts_count }})</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Tags -->
        <div class="col-md-6">
            <div class="home-widget">
                <h3 class="widget-title">Tags</h3>
                <div class="tags">
                    @foreach ($tags as $tag)
                        <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="tag-link">
                            {{ $tag->name }} ({{ $tag->posts_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection