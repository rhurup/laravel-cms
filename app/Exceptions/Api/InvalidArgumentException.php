<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiException;

class InvalidArgumentException extends ApiException
{
    /**
     * Apply custom overrides, like forcing a HTTP statuscode or a fixed message.
     * @see ApiException::getStatusCode()
     * @see ApiException::getStatusMessage()
     */
    public function init()
    {
        $this->statusCode = 403;

        if (!$this->statusMessage) {
            $this->statusMessage = 'Invalid argument made';
        }
    }
}
