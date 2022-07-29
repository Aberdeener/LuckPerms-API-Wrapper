<?php

namespace LuckPermsAPI\Group;

use LuckPermsAPI\Contracts\Repository;
use LuckPermsAPI\Exception\GroupNotFoundException;

class GroupRepository extends Repository
{
    public function load(string $identifier): Group
    {
        if ($this->objects->has($identifier)) {
            return $this->objects->get($identifier);
        }

        $response = $this->session->httpClient->get("/groups/{$identifier}");

        if ($response->getStatusCode() === 404) {
            throw new GroupNotFoundException("Group with name '{$identifier}' not found");
        }

        $group = resolve(GroupMapper::class)->mapSingle(
            $this->json($response->getBody()->getContents())
        );

        $this->objects->put($identifier, $group);

        return $group;
    }
}
