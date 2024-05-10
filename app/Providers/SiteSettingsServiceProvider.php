<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SiteSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $siteSettings = \App\Models\SiteSetting::pluck('value', 'key')->toArray();
            $view->with('siteSettings', $siteSettings);
        });
    }
    
}
