<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\EmailEvent;
use App\Traits\EmailTrait;

class EmailListener
{
    public function __construct(){
    }

    /**
     * Handle the event.
     */
    public function handle(EmailEvent $event): void
    {
        $this->sendRegistration($event->user);
    }
}
