<?php

namespace AppTenant\Mail;

use AppTenant\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompensationEventQuotationNotified extends Mailable
{
    use Queueable, SerializesModels;

    /** @var AppTenant\Models\Quotation */
    public $quotation;

    /**
     * Create a new message instance.
     *
     * @param AppTenant\Models\Quotation $quotation
     * @return void
     */
    public function __construct(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Compensation Event Quotation Notified')
                    ->markdown('tenant.emails.compensation-event-quotation.notified', [
                        'quotation'  => $this->quotation
                    ]);
    }
}
