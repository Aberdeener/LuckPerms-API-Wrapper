<?php

namespace LuckPermsAPI\Group;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Session;

class GroupMapper implements Mapper {

    /**
     * @param Node[] $data
     * @return Collection<Group>
     */
    public static function map(array $data): Collection {
        $groups = new Collection();
        $groupRepository = GroupRepository::get(Session::instance());

        foreach ($data as $groupNode) {
            $groupName = explode('.', $groupNode->value())[0];
            $groups->put($groupName, $groupRepository->load($groupName));
        }

        return $groups;
    }
}
