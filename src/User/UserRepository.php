<?php

namespace LuckPermsAPI\User;

use LuckPermsAPI\Contracts\Repository;

class UserRepository extends Repository
{
    public function load(string $identifier): User
    {
        return $this->objects->getOrPut($identifier, function () use ($identifier) {
            $response = $this->session->httpClient->get("/users/{$identifier}");

            $data = json_decode($response->getBody()->getContents(), true);

            return new User(
                $data['username'],
                $data['uniqueId'],
                $data['nodes'],
                $data['metaData'],
            );
        });
    }
}
