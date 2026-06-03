<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\NotifikasiSingkat;
use App\Filament\Widgets\StatusTahananChart;
use App\Filament\Widgets\TahananBulananChart;
use App\Filament\Widgets\TahananOverview;
use App\Filament\Widgets\TahananTahunanChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
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
            ->login()

            ->brandLogo(fn () => new HtmlString('
                <div style="display:flex; align-items:center; gap:10px; white-space:nowrap;">
                    <img src="' . asset('images/logo.png') . '" style="height:57px;">
                    <span style="font-weight:bold; font-size:18px; color:white;">
                        Sistem Informasi Tahanan
                    </span>
                </div>
            '))

            ->darkMode(isForced: true)

            ->colors([
                'primary' => Color::Indigo,
            ])

            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )

            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )

            ->pages([
                Pages\Dashboard::class,
            ])

            ->widgets([
                TahananOverview::class,
                TahananBulananChart::class,
                TahananTahunanChart::class,
                StatusTahananChart::class,
                NotifikasiSingkat::class,
            ])

            ->navigationItems([
                NavigationItem::make('Logout')
                    ->url(fn (): string => route('filament.admin.auth.logout'))
                    ->icon('heroicon-o-arrow-left-on-rectangle')
                    ->sort(9999),
            ])

            ->renderHook(
                'panels::head.end',
                fn (): HtmlString => new HtmlString(
                    '<style>
                        .fi-sidebar-nav a[href*="logout"] {
                            color: rgb(248 113 113) !important;
                        }

                        .fi-sidebar-nav a[href*="logout"] svg {
                            color: rgb(248 113 113) !important;
                        }

                        .fi-simple-header-heading {
                            font-size: 18px !important;
                        }
                    </style>'
                ),
            )

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