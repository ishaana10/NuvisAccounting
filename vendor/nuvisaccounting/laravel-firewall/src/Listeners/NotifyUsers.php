<?php

namespace NuvisAccounting\Firewall\Listeners;

use NuvisAccounting\Firewall\Events\AttackDetected as Event;
use NuvisAccounting\Firewall\Notifications\AttackDetected;
use NuvisAccounting\Firewall\Notifications\Notifiable;
use Throwable;

class NotifyUsers
{
    /**
     * Handle the event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        try {
            (new Notifiable)->notify(new AttackDetected($event->log));
        } catch (Throwable $e) {
            report($e);
        }
    }
}
