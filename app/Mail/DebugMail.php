<?php

namespace App\Mail;

use Carbon\Carbon;

class DebugMail extends BaseMail
{
    public $exception;


    /**
     * @param $subject
     * @param $exception_stack
     */
    public function init($subject, $exception_stack)
    {
        $this->subject = $subject;
        $this->exception = $exception_stack;
    }


    /**
     *
     */
    public function building()
    {
        $this->view    = 'email.debug';
        $this->with([
            'name'      => $this->subject,
            'exception' => $this->exception,
            'info' => [
                'sent'       => Carbon::now(),
                'queue'      => $this->queue,
                'connection' => $this->connection,
                'server'     => gethostname(),
                'env'        => env('APP_ENV'),
            ]
        ]);
    }
}
