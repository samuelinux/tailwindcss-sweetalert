<?php

namespace SamuelPereiraMachado\TailwindcssSweetalert;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;
use SamuelPereiraMachado\TailwindcssSweetalert\Http\Middleware\InjectAssets;

class TailwindcssSweetalertServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerMiddleware();
        $this->registerMacros();
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
