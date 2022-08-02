<?php

namespace App;

use function cli\line;
use function cli\prompt;

class StartED
{
    private string $event = '';

    public function chooseService(): void
    {
        while (true) {
            line("Welcome to Event Dispatcher.");
            line("If you want create Event: type 'e'.");
            line("If you want to listen subscriber: type 's'.");
            line("For exit type 'exit'");
            $service = prompt("What service start you want");
            switch ($service) {
                case 'e':
                    $this->startDispatcher();
                    break;
                case 's':
                    $this->listenEvents();
                    break;
                case 'exit':
                    return;
                default:
                    echo ("Not support command. Please try again!\n\n");
            }


        }
    }

    public function startDispatcher(): void
    {
        $this->event = prompt("\nWhat Event you Want");
        $event = (new Event($this->event))->getEvent();

        (new Dispatcher($event))->setStatusOpen();

        line("\n----------");
        line("For event:");
        echo ("$this->event\n");
        line("Set status 'open'");
        line("please wait for result.");
        line("-----------------------\n");
    }

    private function listenEvents(): void
    {
        $subscribers = new Subscribers();
        while (true) {
            sleep(3);
            $allStatus = $subscribers->checkOpenEvents();
            if ($this->checkAllStatusDone($allStatus)) {
                line("\n----------------");
                line("ALl events done!");
                line("----------------\n");
            }
        }
    }

    private function checkAllStatusDone($allStatus): bool
    {
        $count = 0;
        foreach ($allStatus as $status) {
            if ($status === 'close') {
                $count++;
            }
        }
        return $count === count($allStatus);
    }
}
