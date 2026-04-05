@extends('installer.layout')
@php $currentStep = 6; @endphp

@section('content')
<div class="nsi-done">
    <div class="nsi-done__icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>

    <h1 style="margin-bottom: 0.5rem;">Instalasi Berhasil</h1>
    <p class="nsi-main__lead" style="margin-bottom: 0;">NebulaCMS siap digunakan.</p>
</div>

<div class="nsi-panel" style="margin-top: 2rem;">
    <div class="nsi-row"><span class="nsi-row__label"><span class="nsi-dot nsi-dot--ok"></span> File konfigurasi ditulis</span></div>
    <div class="nsi-row"><span class="nsi-row__label"><span class="nsi-dot nsi-dot--ok"></span> Migrasi database selesai</span></div>
    <div class="nsi-row"><span class="nsi-row__label"><span class="nsi-dot nsi-dot--ok"></span> Data awal berhasil diisi</span></div>
    <div class="nsi-row"><span class="nsi-row__label"><span class="nsi-dot nsi-dot--ok"></span> Akun administrator dibuat</span></div>
</div>

<div class="nsi-alert nsi-alert--info">
    Installer kini terkunci secara otomatis. Simpan kredensial admin Anda di tempat yang aman.
</div>

<div class="nsi-done__actions">
    <a href="/admin" class="nsi-btn nsi-btn--primary">Masuk ke Admin</a>
    <a href="/" class="nsi-btn nsi-btn--outline">Lihat Situs</a>
</div>
@endsection
