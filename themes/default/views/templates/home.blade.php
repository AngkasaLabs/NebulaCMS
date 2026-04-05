{{--
Template Name: Home Template
Description: Custom template for home page
--}}

@extends('theme::layouts.app')

@section('content')
<div class="home-template">
    <div class="home-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>{{ config('app.name') }}</h1>
                    <p class="lead">Welcome to our website</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Latest Posts</h2>

                @if(isset($latest_posts) && $latest_posts->count() > 0)
                    <div class="row">
                        @foreach($latest_posts as $post)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    @if($post->featured_image)
                                        <img src="{{ $post->featured_image }}" class="card-img-top" alt="{{ $post->title }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">{{ Str::limit($post->excerpt, 100) }}</p>
                                        <a href="{{ url('blog/' . $post->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                                    </div>
                                    <div class="card-footer text-muted">
                                        {{ $post->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No latest posts.</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="sidebar">
                    <h3>Categories</h3>
                    @if(isset($categories) && $categories->count() > 0)
                        <ul class="list-group">
                            @foreach($categories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ url('category/' . $category->slug) }}">{{ $category->name }}</a>
                                    <span class="badge bg-primary rounded-pill">{{ $category->posts_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No categories.</p>
                    @endif

                    <h3 class="mt-4">Tags</h3>
                    @if(isset($tags) && $tags->count() > 0)
                        <div class="tags">
                            @foreach($tags as $tag)
                                <a href="{{ url('tag/' . $tag->slug) }}" class="badge bg-secondary text-decoration-none me-1 mb-1">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    @else
                        <p>No tags.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .home-banner {
        background-color: #f8f9fa;
        padding: 60px 0;
        margin-bottom: 30px;
    }

    .home-banner h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .home-banner .lead {
        font-size: 1.5rem;
    }

    .tags {
        display: flex;
        flex-wrap: wrap;
    }
</style>
@endpush
