<?php

namespace SamuelPereiraMachado\TallAlert;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SamuelPereiraMachado\TallAlert\Http\Controllers\AssetController;

class TallAlertServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tall-alert');

        $this->registerRoutes();

        Blade::component('tall-alert::components.tall-alert', 'tall-alert');
    }

    protected function registerRoutes()
    {
        Route::get('/tall-alert/assets/js', [AssetController::class, 'js'])->name('tall-alert.assets.js');
    }

    public function register()
    {
        //
    }
}
