<?php

namespace App\Exceptions\Laravel;

use App\Exceptions\ApiException;

class PDOException extends ApiException
{
    /**
     * Apply custom overrides, like forcing a HTTP statuscode or a fixed message.
     * @see ApiException::getStatusCode()
     * @see ApiException::getStatusMessage()
     */
    public function init()
    {
        $this->statusCode = 500;
        $this->statusMessage = 'Database issues Found';
    }
}
