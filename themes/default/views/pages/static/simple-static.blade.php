@extends('theme::layouts.app')

@section('title', 'Simple Static Page')
@section('meta_description', 'This is a simple static page.')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1>Halo Dunia</h1>
</div>
@endsection

@push('scripts')
<script>
    // Add any page-specific JavaScript here
    console.log('Simple Static Page loaded');
</script>
@endpush
