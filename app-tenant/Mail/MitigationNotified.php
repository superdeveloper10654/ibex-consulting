<?php

namespace AppTenant\Mail;

use AppTenant\Models\Mitigation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MitigationNotified extends Mailable
{
    use Queueable, SerializesModels;

    /** @var AppTenant\Models\Mitigation */
    public $mitigation;

    /**
     * Create a new message instance.
     *
     * @param AppTenant\Models\Mitigation $mitigation
     * @return void
     */
    public function __construct(Mitigation $mitigation)
    {
        $this->mitigation = $mitigation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Early Warning Notified')
                    ->markdown('tenant.emails.mitigation.notified', [
                        'mitigation'  => $this->mitigation
                    ]);
    }
}