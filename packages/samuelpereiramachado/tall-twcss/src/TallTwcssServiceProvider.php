<?php

namespace SamuelPereiraMachado\TallTwcss;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SamuelPereiraMachado\TallTwcss\Http\Controllers\AssetController;

class TallTwcssServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::get('/tall-twcss/assets/css', [AssetController::class, 'css'])->name('tall-twcss.assets.css');
    }

    public function register()
    {
        //
    }
}