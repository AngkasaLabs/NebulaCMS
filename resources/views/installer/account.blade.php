@extends('installer.layout')
@php $currentStep = 4; @endphp

@section('content')
<h1>Akun Administrator</h1>
<p class="nsi-main__lead">Buat akun super admin untuk mengelola situs Anda.</p>

<form action="{{ route('installer.account.save') }}" method="POST">
    @csrf
    <div class="nsi-panel">
        <div class="nsi-field">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', $data['name']) }}" placeholder="Administrator">
            @error('name')<p class="nsi-field__error">{{ $message }}</p>@enderror
        </div>
        <div class="nsi-field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $data['email']) }}" placeholder="admin@example.com">
            @error('email')<p class="nsi-field__error">{{ $message }}</p>@enderror
        </div>
        <div class="nsi-field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter">
            @error('password')<p class="nsi-field__error">{{ $message }}</p>@enderror
        </div>
        <div class="nsi-field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password">
        </div>
    </div>

    <div class="nsi-alert nsi-alert--info">
        Akun ini akan memiliki akses penuh sebagai <strong>Super Administrator</strong>.
    </div>

    <div class="nsi-actions">
        <a href="{{ route('installer.site') }}" class="nsi-btn nsi-btn--ghost">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <button type="submit" class="nsi-btn nsi-btn--primary">
            Mulai Instalasi
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>
</form>
@endsection
