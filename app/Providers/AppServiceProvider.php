<?php

namespace App\Providers;

use App\Filament\Widgets\TahananBulananChart;
use App\Filament\Widgets\TahananTahunanChart;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('app.filament.widgets.tahanan-bulanan-chart', TahananBulananChart::class);
        Livewire::component('app.filament.widgets.tahanan-tahunan-chart', TahananTahunanChart::class);

        $appUrl = config('app.url');
        if (is_string($appUrl) && $appUrl !== '') {
            URL::forceRootUrl($appUrl);

            $scheme = parse_url($appUrl, PHP_URL_SCHEME);
            if (is_string($scheme) && $scheme !== '') {
                URL::forceScheme($scheme);
            }

            $path = (string) (parse_url($appUrl, PHP_URL_PATH) ?? '');
            $path = '/'.ltrim($path, '/');
            $path = rtrim($path, '/');

            Livewire::setUpdateRoute(function ($handle) use ($path) {
                return Route::post("{$path}/livewire/update", $handle)
                    ->middleware('web')
                    ->name('livewire.update');
            });

            Livewire::setScriptRoute(function ($handle) use ($path) {
                return Route::get("{$path}/livewire/livewire.js", $handle)
                    ->middleware('web');
            });
        }
    }
}
