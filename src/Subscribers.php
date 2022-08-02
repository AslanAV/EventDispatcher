<?php

namespace App;

use App\Listeners\Listener;
use App\Listeners\SendEmail;
use App\Listeners\SendSMS;

class Subscribers
{
    private array $listeners;
    protected array $resultJobListeners = [];
    protected string $dirEvents = __DIR__ . "/../Events/";

    public function __construct()
    {
        $this->listeners = [
            new SendEmail(),
            new SendSMS(),
//            new Listener(),
//            new Listener(),
        ];
    }

    private function startJobListeners(string $newEvent): void
    {
        $progressBar = new ProgressBar(count($this->listeners));

        foreach ($this->listeners as $key => $listener) {
            $message = $this->resultJobListeners[] = $listener->getResult($newEvent);

            $number = $key + 1;
            echo $progressBar->progressBar($number, "Listener №{$number} {$message}") . "\n";
        }
    }

    public function checkOpenEvents(): array
    {
        $files = scandir($this->dirEvents);
        $statusNotClose = [];
        foreach ($files as $nameFile) {
            if ($nameFile === '.' || $nameFile === '..') {
                continue;
            }
            $event = $this->readContentFile($nameFile);
            if ($event['status'] === 'open') {
                $statusNotClose[$event['name']] = $event['status'];
                $name = $event['name'];

                $this->startJobListeners($name);
            }

            $this->setStatusClose($nameFile);
            $statusNotClose[$event['name']] = 'close';
        }
        return $statusNotClose;
    }

    protected function readContentFile($nameFile): mixed
    {
        $nameFile = $this->dirEvents . '/' . $nameFile;
        $content = file_get_contents($nameFile);

        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    protected function setStatusClose(string $nameFile): void
    {
        $event = $this->readContentFile($nameFile);
        $event['status'] = 'close';
        $data = json_encode($event, JSON_THROW_ON_ERROR);

        $filePath = "{$this->dirEvents}{$nameFile}";
        file_put_contents($filePath, $data);
    }
}
