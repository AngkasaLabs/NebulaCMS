@extends('theme::layouts.app')

@section('title', 'Tag: ' . $tag->name)
@section('meta_description', 'Posts tagged with: ' . $tag->name)

@section('content')
    <!-- Tag Header -->
    <header class="page-header">
        <h1 class="page-title">Tag: {{ $tag->name }}</h1>
        @if($tag->description)
            <div class="tag-description">
                <p>{{ $tag->description }}</p>
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

                <a href="{{ route('blog.post', $post->slug) }}" class="read-more">Read More</a>
            </article>
        @empty
            <div class="no-posts">
                <p>No posts found with this tag.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $posts->links() }}
    </div>
@endsection