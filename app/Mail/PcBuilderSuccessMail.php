<?php

namespace App\Mail;

use App\Models\PcBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PcBuilderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public PcBuilder $pcBuilder;

    /**
     * Create a new message instance.
     */
    public function __construct(PcBuilder $pcBuilder)
    {
        $this->pcBuilder = $pcBuilder;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject(
                'PC Builder Order Confirmed - ' .
                $this->pcBuilder->builder_number
            )
            ->view('emails.pc-builder.success');
    }
}