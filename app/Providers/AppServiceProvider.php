<?php

namespace App\Providers;

use App\Http\View\Composers\PostComposer;
use App\Http\View\Composers\PostComposer2;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['dashboard'], PostComposer::class);     
        View::composer(['dashboard2'], PostComposer2::class); 
    }
}
