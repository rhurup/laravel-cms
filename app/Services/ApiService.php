<?php


namespace App\Services;

use App\Exceptions\Laravel\BadMethodCallException;
use App\Models\System\LogOutbound;
use Illuminate\Support\Str;

class ApiService
{
    public $headers;
    public $method;
    public $url;
    public $postdata = false;
    public $curl_options = false;

    private $OutboundLog = false;


    public function __construct(string $url, string $method, array $headers, array $options = [])
    {
        $this->url     = $url;
        $this->method  = $method;
        $this->headers = $headers;
        $this->options = $options;
    }



    public function setCurlCache($enabled = false, $ttl = 4800)
    {

    }

    public function setCurlOptions()
    {
        $this->curl_options = [
            CURLOPT_URL            => $this->url,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Linux; Android 5.0; SM-G920A) AppleWebKit (KHTML, like Gecko) Chrome Mobile Safari (compatible; Laravel-CMS-Bot; +https://github.com/rhurup/laravel-cms)',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_BUFFERSIZE     => 64000,
        ];

        foreach($this->options as $optionKey => $option){
            $this->curl_options[$optionKey] = $option;
        }
        $this->curl_options[CURLOPT_CUSTOMREQUEST] = $this->method;

        if(empty($this->headers)){
            $this->curl_options[CURLOPT_HTTPHEADER] = [
                "Content-Type: application/json",
                "Cache-Control: no-cache",
                "Content-length: " . strlen(json_encode($this->postdata)),
            ];
        }else{
            $this->curl_options[CURLOPT_HTTPHEADER] = $this->headers;
        }
    }

    public function setPostData($postdata)
    {
        $this->postdata = $postdata;
        $this->curl_options[CURLOPT_POSTFIELDS] = $this->postdata;
    }

    public function call()
    {

        $curl = curl_init();

        $this->setCurlOptions();

        $this->OutboundLog = (new LogOutbound())->init($this->url, $this->method, $this->curl_options);

        curl_setopt_array($curl, $this->curl_options);

        $response = curl_exec($curl);

        $info = curl_getinfo($curl);
        $err  = curl_error($curl);
        curl_close($curl);

        if((int)$info['http_code'] !== 200){
            echo "<pre>\n";
            var_dump($response);
            echo "</pre>\n";
            throw new BadMethodCallException("ApiService not received a valid response.", 404);
        }

        $this->OutboundLog->response       = Str::limit($response, 65000);
        $this->OutboundLog->response_code  = $info['http_code'];
        $this->OutboundLog->response_time  = (microtime(true) - $this->OutboundLog->startTime);
        $this->OutboundLog->response_error = $err;
        $this->OutboundLog->save();

        if(in_array($info['content_type'], ['application/json', 'application/json; charset=utf-8'])){
            return json_decode($response);
        }

        return $response;
    }
}