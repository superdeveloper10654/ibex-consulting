<?php

namespace AppTenant\Mail;

use AppTenant\Models\EarlyWarning;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EarlyWarningNotified extends Mailable
{
    use Queueable, SerializesModels;

    /** @var AppTenant\Models\EarlyWarning */
    public $early_warning;

    /**
     * Create a new message instance.
     *
     * @param AppTenant\Models\EarlyWarning $early_warning
     * @return void
     */
    public function __construct(EarlyWarning $early_warning)
    {
        $this->early_warning = $early_warning;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Early Warning Notified')
                    ->markdown('tenant.emails.early-warning.notified', [
                        'early_warning'  => $this->early_warning
                    ]);
    }
}