<?php

namespace LuckPermsAPI\Group;

use LuckPermsAPI\Contracts\Repository;

class GroupRepository extends Repository {

    public function load(string $identifier): Group {
        return $this->objects->getOrPut($identifier, function () use ($identifier) {
            $response = $this->session->httpClient->get("/groups/{$identifier}");

            $data = json_decode($response->getBody()->getContents(), true);

            return GroupMapper::mapSingle($data);
        });
    }

}
