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
        if ($this->objects->has($identifier)) {
            return $this->objects->get($identifier);
        }

        $response = $this->session->httpClient->get("/users/{$identifier}");

        if ($response->getStatusCode() === 404) {
            throw new UserNotFoundException("User with identifier '{$identifier}' not found");
        }

        $data = $this->json($response->getBody()->getContents());

        $user = resolve(UserMapper::class)->mapSingle($data);

        $this->objects->put($identifier, $user);

        return $user;
    }
}
