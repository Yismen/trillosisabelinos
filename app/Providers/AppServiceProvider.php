<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');


            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Event Results')
                    ->icon('heroicon-s-pencil')
                    ->collapsed(false),
                NavigationGroup::make()
                    ->label('Event Setup')
                    ->icon('heroicon-s-shopping-cart')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Backend')
                    ->icon('heroicon-s-cog')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('System')
                    ->icon('heroicon-s-cog')
                    ->collapsed(),
            ]);
        });
    }
}
