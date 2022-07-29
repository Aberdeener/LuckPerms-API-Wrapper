<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Container\Container;
use LuckPermsAPI\Config\ConfigBuilder;
use LuckPermsAPI\Group\GroupRepository;
use LuckPermsAPI\LuckPermsClient;
use LuckPermsAPI\Session;
use LuckPermsAPI\User\UserRepository;

class TestCase extends \PHPUnit\Framework\TestCase {

    protected ?Session $session;
    protected ?Container $container;

    public function setUp(): void
    {
        parent::setUp();

        $this->session = LuckPermsClient::make(
            ConfigBuilder::make()
                ->withBaseUri('https://luckperms.net/api/v2/')
                ->withApiKey('12345')
                ->build(),
        );

        $this->container = LuckPermsClient::container();

        // We need to override these bindings since we will set a mock Guzzle client
        $this->container->singleton(UserRepository::class, function () {
            return new UserRepository($this->session);
        });

        $this->container->singleton(GroupRepository::class, function () {
            return new GroupRepository($this->session);
        });
    }

    protected function createMockClient(array $queue): Client
    {
        $handlerStack = HandlerStack::create(
            new MockHandler($queue),
        );

        return new Client([
            'handler' => $handlerStack,
            'base_uri' => 'https://luckperms.net/api/v2',
            'headers' => [
                'Authorization' => 'Bearer 12345',
            ],
            'http_errors' => false,
        ]);
    }
}
