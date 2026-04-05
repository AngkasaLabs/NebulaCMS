@extends('installer.layout')
@php $currentStep = 1; @endphp

@section('content')
<h1>Persyaratan Sistem</h1>
<p class="nsi-main__lead">Pastikan server Anda memenuhi semua persyaratan berikut sebelum melanjutkan instalasi.</p>

{{-- PHP Version --}}
<div class="nsi-panel">
    <h2 class="nsi-panel__title">PHP</h2>
    <div class="nsi-row">
        <span class="nsi-row__label">
            <span class="nsi-dot {{ $requirements['php']['ok'] ? 'nsi-dot--ok' : 'nsi-dot--fail' }}"></span>
            PHP {{ $requirements['php']['version'] }}
            <span style="color: var(--ns-muted); font-size: 0.75rem;">&mdash; minimal {{ $requirements['php']['required'] }}</span>
        </span>
        <span class="nsi-row__value {{ $requirements['php']['ok'] ? 'nsi-row__value--ok' : 'nsi-row__value--fail' }}">
            {{ $requirements['php']['ok'] ? 'OK' : 'Tidak memenuhi' }}
        </span>
    </div>
</div>

{{-- Extensions --}}
<div class="nsi-panel">
    <h2 class="nsi-panel__title">Ekstensi PHP</h2>
    @foreach($requirements['extensions'] as $ext => $loaded)
    <div class="nsi-row">
        <span class="nsi-row__label">
            <span class="nsi-dot {{ $loaded ? 'nsi-dot--ok' : 'nsi-dot--fail' }}"></span>
            <code>{{ $ext }}</code>
        </span>
        <span class="nsi-row__value {{ $loaded ? 'nsi-row__value--ok' : 'nsi-row__value--fail' }}">
            {{ $loaded ? 'Tersedia' : 'Tidak ditemukan' }}
        </span>
    </div>
    @endforeach
</div>

{{-- Directories --}}
<div class="nsi-panel">
    <h2 class="nsi-panel__title">Izin Direktori</h2>
    @foreach($requirements['paths'] as $label => $writable)
    <div class="nsi-row">
        <span class="nsi-row__label">
            <span class="nsi-dot {{ $writable ? 'nsi-dot--ok' : 'nsi-dot--fail' }}"></span>
            <code>{{ $label }}</code>
        </span>
        <span class="nsi-row__value {{ $writable ? 'nsi-row__value--ok' : 'nsi-row__value--fail' }}">
            {{ $writable ? 'Dapat ditulis' : 'Tidak dapat ditulis' }}
        </span>
    </div>
    @endforeach
</div>

@php
    $allOk = $requirements['php']['ok']
        && !in_array(false, $requirements['extensions'])
        && !in_array(false, $requirements['paths']);
@endphp

@if(!$allOk)
<div class="nsi-alert nsi-alert--error">
    <strong>Persyaratan belum terpenuhi.</strong> Perbaiki item yang gagal di atas sebelum melanjutkan.
</div>
@endif

<div class="nsi-actions" style="justify-content: flex-end;">
    @if($allOk)
        <a href="{{ route('installer.database') }}" class="nsi-btn nsi-btn--primary">
            Lanjutkan
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
        </a>
    @else
        <span class="nsi-btn" style="opacity: 0.4; cursor: not-allowed;">Lanjutkan</span>
    @endif
</div>
@endsection
