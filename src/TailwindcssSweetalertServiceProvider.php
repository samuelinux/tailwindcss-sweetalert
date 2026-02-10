<?php

namespace SamuelPereiraMachado\TailwindcssSweetalert;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;
use SamuelPereiraMachado\TailwindcssSweetalert\Http\Controllers\AssetController;
use SamuelPereiraMachado\TailwindcssSweetalert\Http\Middleware\InjectAssets;

class TailwindcssSweetalertServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        $this->registerMiddleware();
        $this->registerMacros();
    }

    protected function registerRoutes()
    {
        Route::middleware([])->group(function () {
            Route::get('/tailwindcss-sweetalert/css', [AssetController::class, 'css'])
                ->name('tailwindcss-sweetalert.css');

            Route::get('/tailwindcss-sweetalert/js', [AssetController::class, 'js'])
                ->name('tailwindcss-sweetalert.js');
        });
    }

    protected function registerMiddleware()
    {
        /** @var Kernel $kernel */
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(InjectAssets::class);
    }

    protected function registerMacros()
    {
        Component::macro('alert', function (
            string $title,
            string $message = '',
            string $type = 'info',
            array $options = []
        ) {
            $this->dispatch('tall-alert:alert', [
                'title'   => $title,
                'message' => $message,
                'type'    => $type,
                'options' => $options,
            ]);
        });

        Component::macro('confirm', function (
            string $title,
            array $action,
            string $message = '',
            string $type = 'question',
            array $options = []
        ) {
            $this->dispatch('tall-alert:confirm', [
                'title'       => $title,
                'message'     => $message,
                'type'        => $type,
                'action'      => $action,
                'options'     => $options,
                'componentId' => $this->getId(),
            ]);
        });
    }

    public function register()
    {
        //
    }
}
