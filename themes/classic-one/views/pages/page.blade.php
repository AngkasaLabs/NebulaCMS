@extends('theme::layouts.app')

@section('title', $page->title)
@section('meta_description', Str::limit(strip_tags($page->content), 160))

@section('content')
    <article class="page">
        <!-- Page Header -->
        <header class="page-header">
            <h1 class="page-title">{{ $page->title }}</h1>
        </header>

        <!-- Featured Image -->
        @if ($page->featured_image)
            <div class="page-thumbnail">
                <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}">
            </div>
        @endif

        <!-- Page Content -->
        <div class="page-content">
            {!! $page->content !!}
        </div>
    </article>
@endsection

@push('styles')
    <style>
        .page .page-content {
            font-size: 16px;
            line-height: 1.8;
        }

        .page .page-content img {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
        }

        .page .page-content h2,
        .page .page-content h3,
        .page .page-content h4 {
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .page .page-content p {
            margin-bottom: 20px;
        }

        .page .page-content blockquote {
            border-left: 4px solid #0066cc;
            padding-left: 20px;
            margin-left: 0;
            font-style: italic;
            color: #555;
        }
    </style>
@endpush