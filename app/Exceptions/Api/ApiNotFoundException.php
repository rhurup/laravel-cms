<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiException;

class ApiNotFoundException extends ApiException
{
    /**
     * Apply custom overrides, like forcing a HTTP statuscode or a fixed message.
     * @see ApiException::getStatusCode()
     * @see ApiException::getStatusMessage()
     */
    public function init()
    {
        $this->statusCode = 404;
        $this->statusMessage = 'Api not Found';

    }
}