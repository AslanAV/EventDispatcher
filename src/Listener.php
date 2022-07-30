<?php

namespace App\Listener;


use Exception;

class Listener
{
    private int $property;
    public function __construct(int $property)
    {
        $this->property = $property;
    }

    /**
     * @throws Exception
     */
    public function getResult(string $newEvent): string
    {
        if (random_int(0, 1) === 1) {
            sleep($this->property);
            return "{$newEvent} and sleep {$this->property}\n";
        }
        return  "Nothing to return\n";

    }
}