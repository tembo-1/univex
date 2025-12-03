<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">

    <title>{{ $title ?? 'Главная страница' }}</title>

    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/apple-touch-icon-57x57.png') }}">
    <!-- Остальные favicon... -->

    <!-- Preloader Styles -->
    <style>
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 1400;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease-in 0s;
        }

        .loader,
        .loader:before,
        .loader:after {
            border-radius: 50%;
            width: 2.5em;
            height: 2.5em;
            animation-fill-mode: both;
            animation: bblFadInOut 1.8s infinite ease-in-out;
        }

        .loader {
            color: #1998f2;
            font-size: 7px;
            position: relative;
            text-indent: -9999em;
            transform: translateZ(0);
            animation-delay: -0.16s;
        }

        .loader:before,
        .loader:after {
            content: '';
            position: absolute;
            top: 0;
        }

        .loader:before {
            left: -3.5em;
            animation-delay: -0.32s;
        }

        .loader:after {
            left: 3.5em;
        }

        @keyframes bblFadInOut {
            0% {
                box-shadow: 0 2.5em 0 -1.3em;
            }
            40% {
                box-shadow: 0 2.5em 0 0;
            }
            80% {
                box-shadow: 0 2.5em 0 -1.3em;
            }
            100% {
                box-shadow: 0 2.5em 0 -1.3em;
            }
        }

        /* Скрываем preloader после загрузки */
        .preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }
    </style>

    <!-- Vite для стилей и скриптов -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body>
<!-- Preloader -->
<div class="preloader" id="preloader">
    <span class="loader"></span>
</div>

<div class="outer">
    <div class="inner">
        <div class="wrapper">
            <!-- Header -->
            @livewire('header')

            <!-- Main Content -->
            <main class="page">
                {{ $slot }}
            </main>

            <!-- Footer -->
            @livewire('footer')
        </div>
    </div>
</div>


<!-- Скрипт для скрытия preloader -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.getElementById('preloader').classList.add('hidden');
        }, 1000); // 1 секунда
    });
</script>

@stack('scripts')
@livewireScripts
</body>
</html>
