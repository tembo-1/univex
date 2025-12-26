<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Notifications\NotificationResource;
use App\Livewire\MyWidget;
use App\Models\NavigationOrder;
use App\Models\Notification;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->navigationGroups(
                NavigationOrder::query()
                ->orderBy('position')
                ->pluck('name')
                ->toArray()
            )
            ->login()
            ->authGuard('admin')
            ->colors([
                'primary' => Color::hex('#6366f1'),
                'secondary' => Color::hex('#8b5cf6'),
                'success' => Color::hex('#10b981'),
                'warning' => Color::hex('#f59e0b'),
                'danger' => Color::hex('#ef4444'),
                'gray' => Color::Slate,
            ])
            ->maxContentWidth('8xl')
            ->renderHook(
                'panels::styles.after',
                fn () => <<<'CSS'
    <style>
        /* УНИВЕРСАЛЬНЫЙ стиль для ВСЕХ скроллбаров в Filament */
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(99, 102, 241, 0.3) transparent;
        }

        /* Webkit браузеры */
        *::-webkit-scrollbar {
            width: 6px;
        }

        .fi-fo-field-label[name="form.remember"] {
            display: none !important;
        }

        *::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 3px;
            margin: 2px 0;
        }

        *::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.3);
            border-radius: 3px;
            border: 1px solid transparent;
            background-clip: padding-box;
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        *::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.5);
            opacity: 0.8;
        }

        *::-webkit-scrollbar-thumb:active {
            background: rgba(99, 102, 241, 0.7);
        }

        /* Темная тема */
        .dark * {
            scrollbar-color: rgba(99, 102, 241, 0.4) transparent;
        }

        .dark *::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.4);
        }

        .dark *::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.6);
        }
    </style>
    CSS
            )
            ->brandName('Univex Admin')
            ->brandLogo(asset('img/menu/01.svg'))
            ->brandLogoHeight('2rem')
            ->favicon(asset('img/icons/01.svg'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->brandName('Dashboard Univex')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
