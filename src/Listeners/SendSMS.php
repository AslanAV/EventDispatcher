<?php

namespace App\Listeners;

class SendSMS extends Listener
{
    public function doJobs(): void
    {
        //do something
        echo("Sms was sent!\n");
    }
}