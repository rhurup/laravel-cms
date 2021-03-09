<?php

namespace App\Models\System;

use App\Models\BaseModel;
use Carbon\Carbon;

class LogOutbound extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'log_outbound';

    protected $fillable = [
        'resource',
        'url',
        'method',
        'request',
        'response',
        'response_statuscode',
        'response_time',
        'response_error',
    ];

    public $startTime;
    public $endTime;

    public function init(string $url, string $method, $requestdata)
    {
        $this->startTime = microtime(true);
        $this->created_at = Carbon::now()->format("Y-m-d H:i:s");
        $this->url = $url;
        $this->method = $method;
        $this->request = json_encode($requestdata);
        $this->save();

        return $this;
    }

}
