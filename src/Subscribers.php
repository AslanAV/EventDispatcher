<?php

namespace App\Subscribers;

use App\Listener\Listener;
use Exception;

class Subscribers
{
    private array $listeners;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $randomListener = random_int(5, 10);
        for ($i = 0; $i <= $randomListener; $i++) {
            $listener = new Listener(random_int(5, 10));
            $this->listeners[] = $listener;
        }

    }

    public function getListeners(string $newEvent): array
    {
        $result = [];
        foreach ($this->listeners as $listener) {
            $result[] = $listener->getResult($newEvent);
        }
        return $result;
    }

}