<?php

namespace App\Listeners;

class SendEmail extends Listener
{
    public function doJobs(): void
    {
        //do something
        echo("Email was sent!\n");
    }
}