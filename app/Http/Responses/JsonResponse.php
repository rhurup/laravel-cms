<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse as Response;

class JsonResponse extends Response
{
    /**
     * Constructor.
     *
     * @param null $data
     * @param int $status
     * @param string $message
     * @param array $headers
     */
    public function __construct($data = null, $status = 200, $message = '', $headers = [])
    {
        $data = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];

        parent::__construct($data, $status, $headers);
    }


    /**
     * Add a key to output
     *
     * @param $key
     * @param $value
     * @return Response
     */
    public function add($key, $value)
    {
        $data = $this->getData();

        $data->{$key} = $value;

        return $this->setData($data);
    }


    /**
     * Add an entire array to output
     *
     * @param array $array
     * @return Response
     */
    public function addArray($array = [])
    {
        $data = $this->getData();

        foreach ($array as $key => $value) {
            $data->{$key} = $value;
        }

        return $this->setData($data);
    }


    /**
     * Sends HTTP headers and content.
     * Here we can hook into headers and stuff as well, right before things are sent.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function send()
    {
        return parent::send();
    }
}
