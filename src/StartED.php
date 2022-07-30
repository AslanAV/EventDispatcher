<?php

namespace App\StartED;


use App\Dispatcher\Dispatcher;
use App\Event\Event;

class StartED
{
    private string $newEvent;

    public function __construct(string $newEvent)
    {
        $this->newEvent = $newEvent;
    }

    public function welcome(): string
    {
        return "start Event Dispatcher\n";
    }

    public function startDispatcher(): array
    {
        $event = new Event($this->newEvent);
        return (new Dispatcher($event->getEvent()))->DispatchSubsribers();
    }
}