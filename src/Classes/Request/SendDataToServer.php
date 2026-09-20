<?php

namespace Medboubazine\LaravelHelpers\Classes\Request;

use Medboubazine\LaravelHelpers\Classes\Config;
use Medboubazine\LaravelHelpers\Classes\Traits\GuzzleHttpRequest;

final class SendDataToServer
{
    use GuzzleHttpRequest;

    /**
     * Get Uris
     *
     * @return bool
     */
    public function handle(string $server_url, array $form_params): bool
    {
        $response = $this->sendGuzzleHttpRequest("POST", $server_url, [], [
            "form_params" => $form_params,
        ]);

        if ($response->getStatusCode() == 204) {
            return true;
        }

        return false;
    }
}
