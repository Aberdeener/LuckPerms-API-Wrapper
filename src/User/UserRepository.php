<?php

namespace LuckPermsAPI\User;

use GuzzleHttp\Exception\GuzzleException;
use LuckPermsAPI\Contracts\Repository;
use LuckPermsAPI\Exception\UserNotFoundException;

class UserRepository extends Repository
{
    /**
     * @throws GuzzleException
     * @throws UserNotFoundException
     */
    public function load(string $identifier): User
    {
        if ($this->objects->contains($identifier)) {
            return $this->objects->get($identifier);
        }

        $response = $this->session->httpClient->get("/users/{$identifier}");

        if ($response->getStatusCode() === 404) {
            throw new UserNotFoundException("User with identifier '{$identifier}' not found");
        }

        $data = json_decode($response->getBody()->getContents(), true);

        $user = new User(
            $data['username'],
            $data['uniqueId'],
            $data['nodes'],
            $data['metaData'],
        );

        $this->objects->put($identifier, $user);

        return $user;
    }
}
