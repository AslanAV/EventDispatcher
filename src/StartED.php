<?php

namespace App;

use function cli\line;
use function cli\prompt;

class StartED
{
    private string $event;

    public function start(): void
    {
        while (true) {
            line("For exit type 'exit'");
            $this->event = prompt("What Event you Want");
            if ($this->event === 'exit') {
                return;
            }
            line("start Event Dispatcher");

            $this->startDispatcher();

            $this->listenEvents();
        }
    }

    public function startDispatcher(): void
    {
        $event = (new Event($this->event))->getEvent();

        (new Dispatcher($event))->setStatusOpen();
    }

    private function listenEvents(): void
    {
        $subscribers = new Subscribers();
        while (true) {
            $allStatus = $subscribers->checkOpenEvents();
            sleep(3);
            $count = 0;
            foreach ($allStatus as $status) {
                if ($status === 'close') {
                    $count++;
                }
            }
            if ($count === count($allStatus)) {
                return;
            }
        }
    }
}
