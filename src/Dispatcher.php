<?php

namespace App\Dispatcher;


use App\Subscribers\Subscribers;

class Dispatcher
{
    private string $newEvent;

    public function __construct(string $newEvent)
    {
        $this->newEvent = $newEvent;
    }

    public function DispatchSubsribers(): array
    {
        return (new Subscribers())->getListeners($this->newEvent);
    }
}