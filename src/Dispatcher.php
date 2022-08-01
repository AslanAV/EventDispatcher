<?php

namespace App;

use Exception;

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
        $content = '';
        try {
            $content = json_encode(['name' => $this->event, 'status' => 'open'], JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            $log = new Log($e);
            $log->addToLog("Запись в лог: Warning!!! Event status open\n");
        }

        $date = date('Y-m-d H:i:s');
        $nameFile = "{$this->dirEvents}{$this->event}_{$date}";
        file_put_contents($nameFile, $content);
    }
}
