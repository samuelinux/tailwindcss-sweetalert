<?php

namespace SamuelPereiraMachado\TallAlert\Traits;

trait InteractsWithTallAlert
{
    public function alert(string $title, string $message = '', string $type = 'info', array $options = [])
    {
        $this->dispatch('tall-alert:alert', [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'options' => $options,
        ]);
    }

    public function confirm(string $title, array $action, string $message = '', string $type = 'question', array $options = [])
    {
        $this->dispatch('tall-alert:confirm', [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action' => $action,
            'options' => $options,
            'componentId' => $this->getId(),
        ]);
    }
}
