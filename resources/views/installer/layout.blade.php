<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NebulaCMS — Installer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;550;600;700;750&display=swap" rel="stylesheet">
    <style>
        :root {
            --ns-dark: #09090b;
            --ns-dark-2: #18181b;
            --ns-dark-3: #27272a;
            --ns-dark-border: rgba(255, 255, 255, 0.08);
            --ns-dark-text: #fafafa;
            --ns-dark-muted: #a1a1aa;
            --ns-white: #ffffff;
            --ns-light: #fafafa;
            --ns-text: #09090b;
            --ns-text-2: #3f3f46;
            --ns-muted: #71717a;
            --ns-border: #e4e4e7;
            --ns-border-2: #d4d4d8;
            --ns-accent: #4f46e5;
            --ns-accent-hover: #4338ca;
            --ns-max: 640px;
            --ns-font: "Inter", system-ui, -apple-system, sans-serif;
            --ns-radius: 8px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: var(--ns-font);
            font-size: 16px;
            line-height: 1.6;
            color: var(--ns-text);
            background: var(--ns-white);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
        }

        a { color: var(--ns-accent); text-decoration: none; }
        a:hover { text-decoration: underline; }

        .nsi-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--ns-dark);
            border-bottom: 1px solid var(--ns-dark-border);
        }

        .nsi-header__inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1080px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 3.5rem;
        }

        .nsi-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--ns-dark-text) !important;
            text-decoration: none !important;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: -0.01em;
        }

        .nsi-header__badge {
            font-size: 0.6875rem;
            font-weight: 500;
            color: var(--ns-dark-muted);
            padding: 0.2rem 0.55rem;
            border: 1px solid var(--ns-dark-border);
            border-radius: 6px;
        }

        .nsi-steps {
            border-bottom: 1px solid var(--ns-border);
            background: var(--ns-light);
        }

        .nsi-steps__inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            max-width: 1080px;
            margin: 0 auto;
            padding: 0 1.5rem;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .nsi-steps__inner::-webkit-scrollbar { display: none; }

        .nsi-step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 0;
            margin-right: 1.75rem;
            font-size: 0.8125rem;
            font-weight: 450;
            color: var(--ns-muted);
            white-space: nowrap;
            border-bottom: 2px solid transparent;
            transition: color 0.15s;
        }

        .nsi-step:last-child { margin-right: 0; }

        .nsi-step.is-active {
            color: var(--ns-text);
            font-weight: 550;
            border-bottom-color: var(--ns-accent);
        }

        .nsi-step.is-done {
            color: var(--ns-text-2);
        }

        .nsi-step__num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.35rem;
            height: 1.35rem;
            border-radius: 50%;
            font-size: 0.6875rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        .nsi-step__num--pending {
            background: var(--ns-border);
            color: var(--ns-muted);
        }

        .nsi-step__num--active {
            background: var(--ns-accent);
            color: #fff;
        }

        .nsi-step__num--done {
            background: var(--ns-dark);
            color: var(--ns-dark-text);
        }

        .nsi-main {
            flex: 1;
            max-width: var(--ns-max);
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
            width: 100%;
        }

        .nsi-main h1 {
            margin: 0 0 0.35rem;
            font-size: clamp(1.375rem, 3vw, 1.75rem);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .nsi-main__lead {
            margin: 0 0 2rem;
            color: var(--ns-muted);
            font-size: 0.9rem;
        }

        .nsi-panel {
            padding: 0;
            border-radius: var(--ns-radius);
            border: 1px solid var(--ns-border);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .nsi-panel__title {
            padding: 0.85rem 1.25rem;
            margin: 0;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--ns-muted);
            background: var(--ns-light);
            border-bottom: 1px solid var(--ns-border);
        }

        .nsi-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.65rem 1.25rem;
            font-size: 0.8125rem;
            border-bottom: 1px solid var(--ns-border);
        }

        .nsi-row:last-child { border-bottom: none; }

        .nsi-row__label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--ns-text);
            font-weight: 450;
        }

        .nsi-row__label code {
            font-family: "SF Mono", "Fira Code", monospace;
            font-size: 0.8125rem;
        }

        .nsi-row__value {
            font-weight: 500;
            flex-shrink: 0;
        }

        .nsi-row__value--ok { color: #16a34a; }
        .nsi-row__value--fail { color: #dc2626; }

        .nsi-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .nsi-dot--ok { background: #16a34a; }
        .nsi-dot--fail { background: #dc2626; }

        .nsi-field {
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid var(--ns-border);
        }

        .nsi-field:last-child { border-bottom: none; }

        .nsi-field label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--ns-muted);
            margin-bottom: 0.4rem;
        }

        .nsi-field label .nsi-optional {
            text-transform: none;
            letter-spacing: 0;
            font-weight: 450;
        }

        .nsi-field input,
        .nsi-field select {
            width: 100%;
            padding: 0.5rem 0.65rem;
            border-radius: 6px;
            border: 1px solid var(--ns-border);
            background: var(--ns-white);
            color: var(--ns-text);
            font: inherit;
            font-size: 0.875rem;
            outline: none;
        }

        .nsi-field input:focus,
        .nsi-field select:focus {
            border-color: var(--ns-accent);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .nsi-field__error {
            margin-top: 0.3rem;
            font-size: 0.75rem;
            color: #dc2626;
        }

        .nsi-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .nsi-field-row > .nsi-field:first-child {
            border-right: 1px solid var(--ns-border);
        }

        .nsi-radio-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .nsi-radio {
            position: relative;
            cursor: pointer;
        }

        .nsi-radio input { position: absolute; opacity: 0; pointer-events: none; }

        .nsi-radio__box {
            padding: 0.75rem;
            border-radius: 6px;
            border: 1px solid var(--ns-border);
            transition: border-color 0.15s;
        }

        .nsi-radio input:checked + .nsi-radio__box {
            border-color: var(--ns-accent);
            background: rgba(79, 70, 229, 0.04);
        }

        .nsi-radio__box strong {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ns-text);
        }

        .nsi-radio__box span {
            font-size: 0.75rem;
            color: var(--ns-muted);
            line-height: 1.4;
        }

        .nsi-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .nsi-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.6rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 550;
            font-family: inherit;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none !important;
            transition: background 0.15s, box-shadow 0.15s;
            line-height: 1.4;
        }

        .nsi-btn--primary {
            color: #fff !important;
            background: var(--ns-accent);
        }

        .nsi-btn--primary:hover { background: var(--ns-accent-hover); }

        .nsi-btn--outline {
            color: var(--ns-text) !important;
            background: transparent;
            border: 1px solid var(--ns-border);
        }

        .nsi-btn--outline:hover {
            border-color: var(--ns-border-2);
            background: var(--ns-light);
        }

        .nsi-btn--sm {
            padding: 0.4rem 0.85rem;
            font-size: 0.8125rem;
        }

        .nsi-btn--dark {
            color: var(--ns-dark-text) !important;
            background: var(--ns-dark);
        }

        .nsi-btn--dark:hover { background: var(--ns-dark-2); }

        .nsi-btn--ghost {
            color: var(--ns-muted) !important;
            background: transparent;
            border: none;
        }

        .nsi-btn--ghost:hover { color: var(--ns-text) !important; }

        .nsi-alert {
            padding: 0.85rem 1rem;
            border-radius: var(--ns-radius);
            font-size: 0.8125rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            border: 1px solid;
        }

        .nsi-alert--error {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .nsi-alert--info {
            background: var(--ns-light);
            border-color: var(--ns-border);
            color: var(--ns-muted);
        }

        .nsi-alert strong { font-weight: 600; }

        .nsi-progress-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            font-size: 0.8125rem;
            border-bottom: 1px solid var(--ns-border);
            color: var(--ns-muted);
        }

        .nsi-progress-item:last-child { border-bottom: none; }

        .nsi-progress-item.is-running { color: var(--ns-text); font-weight: 500; }
        .nsi-progress-item.is-done { color: var(--ns-text-2); }
        .nsi-progress-item.is-error { color: #dc2626; }

        .nsi-progress-icon {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes nsi-spin {
            to { transform: rotate(360deg); }
        }

        .nsi-spinner {
            width: 1rem;
            height: 1rem;
            border: 2px solid var(--ns-border);
            border-top-color: var(--ns-accent);
            border-radius: 50%;
            animation: nsi-spin 0.6s linear infinite;
        }

        .nsi-progress-bar {
            height: 3px;
            background: var(--ns-border);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .nsi-progress-bar__fill {
            height: 100%;
            background: var(--ns-accent);
            border-radius: 2px;
            transition: width 0.5s ease;
            width: 0;
        }

        .nsi-done {
            text-align: center;
            padding: 2rem 0 1rem;
        }

        .nsi-done__icon {
            width: 3.5rem;
            height: 3.5rem;
            margin: 0 auto 1.25rem;
            border-radius: 50%;
            background: rgba(22, 163, 74, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nsi-done__actions {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .nsi-footer {
            border-top: 1px solid var(--ns-border);
            padding: 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--ns-muted);
        }

        @media (max-width: 640px) {
            .nsi-field-row { grid-template-columns: 1fr; }
            .nsi-field-row > .nsi-field:first-child {
                border-right: none;
            }
            .nsi-radio-group { grid-template-columns: 1fr; }
        }
    </style>
    @stack('head')
</head>
<body>

<header class="nsi-header">
    <div class="nsi-header__inner">
        <span class="nsi-logo">NebulaCMS</span>
        <span class="nsi-header__badge">Installer</span>
    </div>
</header>

@php
    $steps = [
        1 => 'Persyaratan',
        2 => 'Database',
        3 => 'Situs',
        4 => 'Admin',
        5 => 'Instal',
        6 => 'Selesai',
    ];
    $currentStep = $currentStep ?? 1;
@endphp

<nav class="nsi-steps">
    <div class="nsi-steps__inner">
        @foreach($steps as $num => $label)
            @php
                $isDone   = $num < $currentStep;
                $isActive = $num === $currentStep;
            @endphp
            <div class="nsi-step {{ $isActive ? 'is-active' : '' }} {{ $isDone ? 'is-done' : '' }}">
                <span class="nsi-step__num {{ $isDone ? 'nsi-step__num--done' : ($isActive ? 'nsi-step__num--active' : 'nsi-step__num--pending') }}">
                    @if($isDone)
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                    @else
                        {{ $num }}
                    @endif
                </span>
                {{ $label }}
            </div>
        @endforeach
    </div>
</nav>

<main class="nsi-main">
    @yield('content')
</main>

<footer class="nsi-footer">
    &copy; {{ date('Y') }} NebulaCMS
</footer>

@stack('scripts')
</body>
</html>
