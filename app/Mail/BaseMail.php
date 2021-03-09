<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer as MailerContract;


abstract class BaseMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    /**
     * BaseMail constructor.
     */
    public function __construct()
    {
        // Send all emails through this queue
        $this->queue = env('MAIL_QUEUE', 'emails');

        // Use this connect by default
        $this->connection = env('MAIL_CONNECTION', 'sync');

        // We can also postpone all emails with this delay
        $this->delay = 0;

        // Apply other settings that goes for all emails
        $this->setDefaults();

        // If we called the email with arguments, make sure an init method can take care of them
        if (method_exists($this, 'init')) {
            call_user_func_array([$this, 'init'], func_get_args());
        }
    }


    /**
     *
     */
    protected function setDefaults()
    {
        //$this->from(env('MAIL_FROM_ADDRESS'));
    }


    /**
     * Default build method - can be overridden
     *
     * @return BaseMail
     */
    public function build()
    {
        // If we have a need to do custom work upon building email, lets  do that
        if (method_exists($this, 'building')) {
            call_user_func_array([$this, 'building'], func_get_args());
        }

        return $this->view($this->view);
    }


    /**
     * Default send method - can be overridden
     *
     * @param  \Illuminate\Contracts\Mail\Factory|\Illuminate\Contracts\Mail\Mailer  $mailer
     * @return void
     */
    public function send($mailer)
    {
        // If we have a need to do custom work upon sending email, lets  do that
        if (method_exists($this, 'sending')) {
            call_user_func_array([$this, 'sending'], func_get_args());
        }

        return parent::send($mailer);
    }
}
