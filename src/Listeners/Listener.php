<?php

namespace App\Listeners;

class Listener
{
    private int $property;


    public function __construct()
    {
        $this->property = random_int(5, 10);
    }

    public function getResult(string $newEvent): string
    {
        $this->doJobs();
        if (random_int(0, 1) === 1) {
            sleep($this->property);
            return 'Done!';
        }
        return 'Not Done!';
    }



}
