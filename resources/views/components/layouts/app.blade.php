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

        .notifications-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 3000;
            max-width: 350px;
        }

        .notification-footer {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .notification-hide-btn {
            background: none;
            border: none;
            color: #999;
            font-size: 12px;
            cursor: pointer;
            padding: 0;
        }

        .notification-hide-btn:hover {
            color: #333;
            text-decoration: underline;
        }

        .notification-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 0 0 8px 8px;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #1998f2, #2ecc71);
            transition: width 0.05s linear;
            border-radius: 0 0 0 8px;
        }

        .notification-item {
            background: white;
            border-left: 4px solid #1998f2;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 8px;
            position: relative;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .notification-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
            font-size: 16px;
            flex: 1;
            padding-right: 10px;
        }

        .notification-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #999;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .notification-close:hover {
            background: #f5f5f5;
            color: #333;
        }

        .notification-content {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .notification-time {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
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
            @livewire('components.blocks.header')

            <!-- Main Content -->
            <main class="page">
                <div class="consent">
                    <div class="consent__inner">
                        <div class="consent__text">Мы используем файлы cookie, чтобы улучшить сайт для Вас</div>
                        <button type="button" class="consent__btn btn">Согласен</button>
                    </div>
                </div>
                @livewire('components.blocks.breadcrumbs')
                {{ $slot }}
            </main>
            <!-- Footer -->
            @livewire('components.blocks.footer')
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

    document.addEventListener('livewire:init', () => {
        Livewire.hook('request', ({ fail }) => {
            fail(({ status, preventDefault }) => {
                if (status === 419) {
                    // Автоматическое обновление через 1 секунду
                    setTimeout(() => {
                        location.reload();
                    }, 1000);

                    preventDefault();
                }
            });
        });
    });

    window.d = 13631490;
</script>
@stack('scripts')
@livewire('components.blocks.toast')
@livewireScripts

@livewire('components.blocks.notification-display')

<template id="errors-code" data-filemax="Количество загружаемых файлов не должно превышать 5" data-filetype="Не является изображением" data-filesize="Превышает максимальный объем файла в 1.3мб" data-size="1363149" data-max="5"></template>

</body>
</html>
