<?php

namespace DeBetooging\Providers;

use DeBetooging\Frontend;
use DeBetooging\Admin;
use Illuminate\Support\ServiceProvider;

class DeBetoogingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('de_betooging.frontend', function () {
            return new \DeBetooging\Frontend();
        });

        $this->app->singleton('de_betooging.admin', function () {
            return new \DeBetooging\Admin();
        });

        $this->app->singleton('de_betooging.contact_information', function () {
            return new \DeBetooging\ContactInformation();
        });

        $this->app->singleton('de_betooging.social_media', function () {
            return new \DeBetooging\SocialMedia();
        });
    }
    
    public function boot()
    {
        collect([
            Frontend::class,
            Admin::class,
        ])
            ->each(function ($class) {
                (new $class())->runHooks();
            });
    }
}
