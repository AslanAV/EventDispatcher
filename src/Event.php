<?php

namespace App;

class Event
{
    protected string $event;

    public function __construct(string $newEvent)
    {
        $this->event = $newEvent;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}
