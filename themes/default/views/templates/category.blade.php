{{--
Template Name: Category Template
Description: Custom template for category page
--}}

@extends('theme::layouts.app')

@section('content')
<div class="category-template">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Category: {{ $category->name }}</h1>
                @if($category->description)
                    <div class="category-description mb-4">
                        {{ $category->description }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                @if($posts->count() > 0)
                    <div class="row">
                        @foreach($posts as $post)
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

                    <div class="pagination-container">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        No posts in this category.
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="sidebar">
                    <h3>Other Categories</h3>
                    @if(isset($categories) && $categories->count() > 0)
                        <ul class="list-group">
                            @foreach($categories as $cat)
                                <li class="list-group-item d-flex justify-content-between align-items-center {{ $cat->id == $category->id ? 'active' : '' }}">
                                    <a href="{{ url('category/' . $cat->slug) }}" class="{{ $cat->id == $category->id ? 'text-white' : '' }}">{{ $cat->name }}</a>
                                    <span class="badge {{ $cat->id == $category->id ? 'bg-light text-dark' : 'bg-primary' }} rounded-pill">{{ $cat->posts_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No other categories.</p>
                    @endif

                    <h3 class="mt-4">Related Tags</h3>
                    @if(isset($related_tags) && $related_tags->count() > 0)
                        <div class="tags">
                            @foreach($related_tags as $tag)
                                <a href="{{ url('tag/' . $tag->slug) }}" class="badge bg-secondary text-decoration-none me-1 mb-1">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    @else
                        <p>No related tags.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .category-description {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .list-group-item.active {
        background-color: #007bff;
        border-color: #007bff;
    }

    .tags {
        display: flex;
        flex-wrap: wrap;
    }
</style>
@endpush
