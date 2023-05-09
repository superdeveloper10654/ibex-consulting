<?php

namespace AppTenant\Mail;

use AppTenant\Models\CompensationEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompensationEventNotificationNotified extends Mailable
{
    use Queueable, SerializesModels;

    /** @var AppTenant\Models\CompensationEvent */
    public $compensation_event;

    /**
     * Create a new message instance.
     *
     * @param AppTenant\Models\CompensationEvent $compensation_event
     * @return void
     */
    public function __construct(CompensationEvent $compensation_event)
    {
        $this->compensation_event = $compensation_event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Compensation Event Notification Notified')
                    ->markdown('tenant.emails.compensation-event-notification.notified', [
                        'compensation_event'  => $this->compensation_event
                    ]);
    }
}
