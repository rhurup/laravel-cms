<?php

namespace App\Mail;

class ResetPassword extends BaseMail
{
    public $name;
    public $token;
    public $until;


    /**
     * @param $name
     * @param $token
     * @param $expirationDate
     */
    public function init($name, $token)
    {
        $this->name = $name;
        $this->token = $token;
    }


    /**
     *
     */
    public function building()
    {
        $this->view    = 'emails.users.reset_password';
        $this->subject = __('users.reset_password');
    }
}
