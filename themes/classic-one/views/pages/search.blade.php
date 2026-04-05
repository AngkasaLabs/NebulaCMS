@extends('theme::layouts.app')

@section('title', 'Search Results for: ' . request('search'))

@section('content')
    <!-- Search Header -->
    <header class="page-header">
        <h1 class="page-title">Search Results</h1>
        <div class="search-query">
            <p>Showing results for: <strong>"{{ request('search') }}"</strong></p>
            <a href="{{ route('blog') }}" class="clear-search">Clear search</a>
        </div>
    </header>

    <!-- Search Results -->
    <div class="search-results">
        @if($posts->count() > 0)
            @foreach($posts as $post)
                <article class="post">
                    @if ($post->featured_image)
                        <div class="post-thumbnail">
                            <a href="{{ route('blog.post', $post->slug) }}">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                    @endif

                    <h2 class="post-title">
                        <a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a>
                    </h2>

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

            <!-- Pagination -->
            <div class="pagination">
                {{ $posts->appends(['search' => request('search')])->links() }}
            </div>
        @else
            <div class="no-results">
                <p>No results found for <strong>"{{ request('search') }}"</strong>.</p>
                <p>Please try another search term or browse our <a href="{{ route('blog') }}">latest posts</a>.</p>
            </div>
        @endif
    </div>
@endsection