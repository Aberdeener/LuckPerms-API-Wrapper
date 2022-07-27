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
    }

    public function userRepository(): UserRepository
    {
        return UserRepository::get($this);
    }

    public function groupRepository(): GroupRepository
    {
        return GroupRepository::get($this);
    }
}
