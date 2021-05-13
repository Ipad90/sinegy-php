<?php

namespace Ipad90\Sinegy;

class Base {
    private $host = "https://api.sinegy.com";
    protected $version = "/api/v1";

    public function __construct($api_key, $secret_key)
    {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;
    }

    protected function signature($method, $url, $parameters)
    {
        $parameters["timestamp"] = $this->timestamp();
        $parameters = http_build_query($parameters);
        $signature = "{$method}|{$url}|{$parameters}";
        $signature = hash_hmac('sha256', $signature, $this->secret_key, true);
        return base64_encode($signature);
    }

    protected function timestamp()
    {
        return round(microtime(true) * 1000);
    }

    protected function curlAPI($method, $url, $parameters)
    {
        $headers = [
            "api-key: {$this->api_key}",
            "Content-Type: application/x-www-form-urlencoded"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->host}{$url}");
        curl_setopt($ch, CURLOPT_USERAGENT, "Ur mom gay");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($method != 'GET') {
            $parameters = http_build_query($parameters);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);

        return $result;
    }
}
