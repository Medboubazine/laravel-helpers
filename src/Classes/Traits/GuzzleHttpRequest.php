<?php

namespace Medboubazine\LaravelHelpers\Classes\Traits;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait GuzzleHttpRequest
{
    /**
     * Send Request via guzzle http
     *
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param array $options
     * @return ResponseInterface
     */
    public function sendGuzzleHttpRequest(string $method, string $uri, array $headers = [], array $options = []): ResponseInterface
    {
        $client = new Client();
        ///
        /// Request Configurations
        ///
        if (isset($options['headers'])) {
            $headers = array_merge($headers, $options['headers']);
            unset($options['headers']);
        }
        $options = [
            "allow_redirects" => false,
            "timeout" => 5,
            "connect_timeout" => 3,
            "http_errors" => false,
            "verify" => false,
            "headers" => $headers,
            ...$options,
        ];
        ///
        /// Response
        ///
        return $client->request($method, $uri, $options);
    }
}
