<?php

namespace App\Mail;

use App\Models\connect_model;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class connect_subscribe extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;

    /**
     * Create a new message instance.
     */
    public function __construct(connect_model $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Exciting Updates Await!')
                    ->view('connect.connect_nsubscribe'); //subscribe blade to use for gmail
    }
}