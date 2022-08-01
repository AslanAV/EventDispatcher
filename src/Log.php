<?php

namespace App;

class Log
{
    public string $e;
    protected string $fileLog = __DIR__ . "/../Logs/log.txt";

    public function __construct(string $e = "Done!")
    {
        $this->e = $e;
    }

    public function addToLog(string $message): void
    {
        $log = date('Y-m-d H:i:s') . $message;
        file_put_contents($this->fileLog, $log, FILE_APPEND);
        file_put_contents($this->fileLog, $this->e, FILE_APPEND);
    }
}
