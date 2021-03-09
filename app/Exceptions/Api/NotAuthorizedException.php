<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiException;

class NotAuthorizedException extends ApiException
{
    /**
     * Apply custom overrides, like forcing a HTTP statuscode or a fixed message.
     * @see ApiException::getStatusCode()
     * @see ApiException::getStatusMessage()
     */
    public function init()
    {
        $this->statusCode = 403;
        $this->statusMessage = 'Not Authorized to this action';
    }
}
