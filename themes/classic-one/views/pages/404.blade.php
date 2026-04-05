@extends('theme::layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
    <div class="error-page">
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        <p class="error-description">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        
        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn-primary">
                <i class="fa fa-home"></i> Back to Home
            </a>
            <a href="{{ route('blog') }}" class="btn-secondary">
                <i class="fa fa-book"></i> Go to Blog
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .error-page {
            text-align: center;
            padding: 50px 0;
        }
        
        .error-code {
            font-size: 120px;
            color: #0066cc;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .error-title {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .error-description {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }
        
        .error-actions {
            margin-top: 30px;
        }
        
        .error-actions a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 3px;
        }
        
        .error-actions .btn-primary {
            background-color: #0066cc;
            color: #fff;
        }
        
        .error-actions .btn-secondary {
            background-color: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .error-actions i {
            margin-right: 5px;
        }
    </style>
@endpush