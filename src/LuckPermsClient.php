<?php

namespace LuckPermsAPI;

use GuzzleHttp\Client as HttpClient;
use LuckPermsAPI\Config\LuckPermsClientConfig;
use LuckPermsAPI\Exception\ClientNotInitiatedException;

class LuckPermsClient
{
    private static Session $session;

    public static function make(LuckPermsClientConfig $config): Session
    {
        return self::$session ??= new Session(new HttpClient([
            'base_uri' => $config->baseUri,
            'headers' => [
                'Authorization' => 'Bearer '.$config->apiKey,
            ],
            'http_errors' => false,
        ]));
    }

    /**
     * @throws ClientNotInitiatedException
     */
    public static function session(): Session
    {
        return self::$session ?? throw new ClientNotInitiatedException;
    }
}
