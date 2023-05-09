<?php

namespace AppTenant\Mail;

use AppTenant\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractEdited extends Mailable
{
    use Queueable, SerializesModels;

    /** @var AppTenant\Models\Contract */
    public $contract;

    /**
     * Create a new message instance.
     *
     * @param AppTenant\Models\Contract $contract
     * @return void
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contract Edited')
                    ->markdown('tenant.emails.contract.edited', [
                        'contract'  => $this->contract
                    ]);
    }
}
