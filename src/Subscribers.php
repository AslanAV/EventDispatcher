<?php

namespace App;

use App\Listeners\Listener;
use Exception;

class Subscribers
{
    private array $listeners;
    protected array $resultJobListeners = [];
    protected string $dirEvents = __DIR__ . "/../Events/";

    public function __construct()
    {
        $this->listeners = [
            new Listener(),
            new Listener(),
            new Listener(),
            new Listener(),
        ];
    }

    private function startJobListeners(string $newEvent): void
    {
        $progressBar = new ProgressBar(count($this->listeners));
        foreach ($this->listeners as $key => $listener) {
            $this->resultJobListeners[] = $listener->getResult($newEvent);

            $number = $key + 1;
            echo $progressBar->progressBar($number, "Listener №{$number} done!") . "\n";
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
            $this->checkResultJobListeners();
            $this->setStatusClose($nameFile);
            $statusNotClose[$event['name']] = 'close';
        }
        return $statusNotClose;
    }

    protected function checkResultJobListeners(): void
    {
        $resultsJobListener = $this->resultJobListeners;
        foreach ($resultsJobListener as $key => $result) {
            if ($result !== 'Done') {
                $log = new Log();
                $log->addToLog("Запись в лог: Warning!!! Result Jobs Listener №{$key} not Done!!!\n");
            }
        }
    }

    protected function readContentFile($nameFile): mixed
    {
        $nameFile = $this->dirEvents . '/' . $nameFile;
        $content = file_get_contents($nameFile);
        $event = [];
        try {
            $event = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            $log = new Log($e);
            $log->addToLog("Запись в лог: Warning!!! Subsribers status start listen\n");
        }
        return $event;
    }

    protected function setStatusClose(string $nameFile): void
    {
        $event = $this->readContentFile($nameFile);
        $event['status'] = 'close';
        $data = '';
        try {
            $data = json_encode($event, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            $log = new Log($e);
            $log->addToLog("Запись в лог: Warning!!! setStatusClose name = {$nameFile}\n");
        }
        $filePath = $this->dirEvents . $nameFile;
        file_put_contents($filePath, $data);
    }
}
