@extends('theme::layouts.app')

@section('title', 'Blog')

@section('content')
    <!-- Blog Header -->
    <header class="page-header">
        <h1 class="page-title">Blog</h1>
        
        <!-- Search Results Info -->
        @if (request('search') || request('category') || request('tag'))
            <div class="search-results-info">
                <p>
                    Showing results for:
                    @if (request('search'))
                        <strong>Search: "{{ request('search') }}"</strong>
                    @endif
                    @if (request('category'))
                        <strong>Category: "{{ $categories->firstWhere('slug', request('category'))->name }}"</strong>
                    @endif
                    @if (request('tag'))
                        <strong>Tag: "{{ $tags->firstWhere('slug', request('tag'))->name }}"</strong>
                    @endif
                </p>
                <a href="{{ route('blog') }}" class="clear-filters">Clear filters</a>
            </div>
        @endif
    </header>

    <!-- Posts List -->
    <div class="posts-list">
        @forelse($posts as $post)
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

                <!-- Post Tags -->
                @if ($post->tags->count() > 0)
                    <div class="post-tags">
                        <i class="fa fa-tags"></i>
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="tag-link">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <a href="{{ route('blog.post', $post->slug) }}" class="read-more">Read More</a>
            </article>
        @empty
            <div class="no-posts">
                <p>No posts found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $posts->links() }}
    </div>
@endsection