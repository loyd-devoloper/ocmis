<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuccessPayment extends Mailable
{
    use Queueable, SerializesModels;
    public $customerName;
    public $paymentMethod;
    public $paymentAmount;
    public $transactionId;
    public $paymentDate;
    /**
     * Create a new message instance.
     */
    public function __construct($customerName,$paymentMethod,$paymentAmount,$transactionId,$paymentDate)
    {
        $this->customerName = $customerName;
        $this->paymentMethod = $paymentMethod;
        $this->paymentAmount = $paymentAmount;
        $this->transactionId = $transactionId;
        $this->paymentDate = $paymentDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Successful',

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.success',
            with:[
                'paymentDate'=>$this->paymentDate,
                'customerName'=>$this->customerName,
                'paymentMethod'=>$this->paymentMethod,
                'paymentAmount'=>$this->paymentAmount,
                'transactionId'=>$this->transactionId,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
