<?php

namespace LuckPermsAPI;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Container\Container;
use LuckPermsAPI\Config\LuckPermsClientConfig;
use LuckPermsAPI\Exception\ClientNotInitiatedException;

class LuckPermsClient
{
    private static Session $session;
    private static Container $container;

    public static function make(LuckPermsClientConfig $config): Session
    {
        self::$container = new Container();

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
        return self::$session ?? throw new ClientNotInitiatedException();
    }

    /**
     * @throws ClientNotInitiatedException
     */
    public static function container(): Container
    {
        return self::$container ?? throw new ClientNotInitiatedException();
    }
}
