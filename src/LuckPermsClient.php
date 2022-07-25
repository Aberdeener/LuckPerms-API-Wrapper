<?php

namespace LuckPermsAPI;

use GuzzleHttp\Client as HttpClient;
use LuckPermsAPI\Config\LuckPermsClientConfig;

class LuckPermsClient {

    /**
     * @throws Exception\LuckPermsConnectionException
     */
    public static function make(LuckPermsClientConfig $config): Session
    {
        return new Session(new HttpClient([
            'base_uri' => $config->baseUri,
            'headers' => [
                'Authorization' => 'Bearer ' . $config->apiKey,
            ],
        ]));
    }
}
