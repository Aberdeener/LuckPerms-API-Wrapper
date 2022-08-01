<?php

namespace LuckPermsAPI\Group;

use LuckPermsAPI\Contracts\Mapper;
use LuckPermsAPI\LuckPermsClient;

class UserGroupMapper implements Mapper
{
    public function map(array $data): UserGroup
    {
        $groupName = explode('group.', $data['key'])[1];
        $group = LuckPermsClient::session()->groupRepository()->load($groupName);

        return new UserGroup(
            $group->name(),
            $group->displayName(),
            $group->weight(),
            $group->metaData()->toArray(),
            $group->nodes()->toArray(),
            $data['value'],
            $data['context'],
            $data['expiry'] ?? 0,
        );
    }
}
