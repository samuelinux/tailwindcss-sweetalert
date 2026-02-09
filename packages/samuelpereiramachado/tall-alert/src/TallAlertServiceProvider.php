<?php

namespace SamuelPereiraMachado\TallAlert;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;
use SamuelPereiraMachado\TallAlert\Http\Controllers\AssetController;

class TallAlertServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tall-alert');

        $this->registerRoutes();
        $this->registerMacros();

        Blade::component('tall-alert::components.tall-alert', 'tall-alert');
    }

    protected function registerRoutes()
    {
        Route::get('/tall-alert/assets/js', [AssetController::class, 'js'])->name('tall-alert.assets.js');
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
