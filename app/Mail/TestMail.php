<?php

namespace App\Mail;

use Carbon\Carbon;

class TestMail extends BaseMail
{
    public $recipients = [];


    /**
     * @param $recipient
     * @param bool $useQueue
     */
    public function init($recipient, $useQueue = false)
    {
        $this->recipients = (array)$recipient;

        if ($useQueue) {
            $this->onConnection('redis');
        } else {
            $this->onConnection('sync');
        }
    }


    /**
     *
     */
    public function building()
    {
        $this->view    = 'email.test';
        $this->subject = 'Test email';
        $this->with([
            'info' => [
                'recipient'  => implode(',', $this->recipients),
                'sent'       => Carbon::now(),
                'queue'      => $this->queue,
                'connection' => $this->connection,
                'server'     => gethostname(),
                'env'        => env('APP_ENV'),
            ]
        ]);
    }
}
