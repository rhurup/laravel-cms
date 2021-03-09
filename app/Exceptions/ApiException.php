<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiException extends \RuntimeException implements HttpExceptionInterface
{
    protected $statusCode = 0;
    protected $statusMessage = '';
    protected $headers = [];


    /**
     * @param string|null $message
     * @param int $code
     * @param Throwable|null $previous
     * @param array $headers
     */
    public function __construct(string $message = null, int $code = 0, Throwable $previous = null, array $headers = [])
    {
        $this->statusCode = $code;
        $this->statusMessage = $message;
        $this->headers = [];

        // Init exception
        parent::__construct($message, $code, $previous);

        // And apply any overrides
        if (method_exists($this, 'init')) {
            $this->init();
        }

        // If exception was called without arguments, set message from status
        if (!$this->getMessage()) {
            $this->message = $this->statusMessage;
        }
    }


    /**
     * Returns the status code.
     * Note - This code is used on API responses and is NOT the same as getCode()
     *
     * @return int An HTTP response status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


    /**
     * Returns the status message.
     * Note - This message is used on API responses and is NOT the same as getMessage()
     *
     * @return string An HTTP response status message
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }


    /**
     * Returns response headers.
     *
     * @return array Response headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }












}
