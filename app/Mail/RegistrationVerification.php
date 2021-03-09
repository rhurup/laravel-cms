<?php

namespace App\Mail;

class RegistrationVerification extends BaseMail
{
    public $token;
    public $name;
    public $expirationDate;


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
        $this->view    = 'emails.users.verify_email';
        $this->subject = __('users.registration_verification');
        $this->with([
            'name' => $this->name,
            'token' => $this->token,
            'link' => env('APP_URL') . '/?confirm-email=' . $this->token,
        ]);
    }
}
