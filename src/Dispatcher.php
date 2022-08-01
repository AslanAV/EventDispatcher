<?php

namespace App;

class Dispatcher
{
    protected string $dirEvents = __DIR__ . "/../Events/";
    private string $event;

    public function __construct(string $newEvent)
    {
        $this->event = $newEvent;
    }


    public function setStatusOpen(): void
    {
        $content = json_encode(['name' => $this->event, 'status' => 'open'], JSON_THROW_ON_ERROR);
        $date = date('Y-m-d H:i:s');
        $nameFile = "{$this->dirEvents}{$this->event}_{$date}.json";
        file_put_contents($nameFile, $content);
    }
}
