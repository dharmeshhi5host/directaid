<?php

namespace App\Providers;

use App\Traits\GeneralTrait;
use Illuminate\Support\ServiceProvider;

class CustomConfigServiceProvider extends ServiceProvider
{
    use GeneralTrait;
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
       
        
    }
}
