<?php

namespace App\Http\Livewire\Traits;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;

/**
 * Add the capacity to handle sweet alert confirmation before performing certain actions.
 */
trait HasConfirmation
{
    public function sweetalertConfirmed(array $payload)
    {
        $method = $payload['envelope']['notification']['options']['confirmation_method'] ?? null;

        if ($method) {
            $this->$method();
        }
    }

    public function confirm(
        string $confirmation_method,
        string|null $message = 'Are you sure?',
        string $type = NotificationInterface::INFO
    ): Envelope {
        return sweetalert(
            $message,
            $type,
            [
                'confirmation_method' => $confirmation_method,
                'timer' => 0,
                'showDenyButton' => true,
                'denyButtonText' => 'NO',
                'confirmButtonText' => 'SI',
            ]
        );
    }

    public function inform(
        string|null $message = 'Are you sure?',
        string|null $viewContent = null,
        string|null $confirmationButtonText = 'INFO'
        
    ): Envelope {
        return sweetalert(
            $message,
            NotificationInterface::INFO,
            [
                'timer' => 0,
                'showDenyButton' => false,
                'confirmButtonText' => $confirmationButtonText,
                'html' => $viewContent,
                'backdrop' => false
            ]
        );
    }

    public function alert(
        string|null $message = 'Alert message',
        string $type = NotificationInterface::INFO
    ): Envelope {
        return sweetalert(
            $message,
            $type,
            [
                'timer' => 0,
            ]
        );
    }

    public function flash(string $message, string $type = NotificationInterface::SUCCESS, array $options = [])
    {
        return flasher($message, $type, $options);
    }

    protected function getListeners()
    {
        return  array_merge(
            $this->listeners,
            ['sweetalertConfirmed']
        );
    }
}