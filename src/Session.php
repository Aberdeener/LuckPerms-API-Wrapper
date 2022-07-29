<?php

namespace LuckPermsAPI;

use GuzzleHttp\Client as HttpClient;
use LuckPermsAPI\Group\GroupRepository;
use LuckPermsAPI\User\UserRepository;

class Session
{
    public HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->registerContainerBindings();
    }

    private function registerContainerBindings(): void
    {
        $container = LuckPermsClient::container();

        $container->singleton(UserRepository::class, function () {
            return new UserRepository($this);
        });

        $container->singleton(GroupRepository::class, function () {
            return new GroupRepository($this);
        });
    }

    public function userRepository(): UserRepository
    {
        return resolve(UserRepository::class);
    }

    public function groupRepository(): GroupRepository
    {
        return resolve(GroupRepository::class);
    }
}
