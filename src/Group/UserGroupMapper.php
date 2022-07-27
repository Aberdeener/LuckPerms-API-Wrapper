<?php

namespace LuckPermsAPI\Group;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;
use LuckPermsAPI\Exception\ClientNotInitiatedException;
use LuckPermsAPI\LuckPermsClient;
use LuckPermsAPI\Node\Node;

class UserGroupMapper implements Mapper
{
    /**
     * @param array $data
     *
     * @return Collection<UserGroup>
     * @throws ClientNotInitiatedException
     */
    public static function map(array $data): Collection
    {
        $userGroups = new Collection();

        foreach ($data as $groupData) {
            $groupName = explode('group.', $groupData['key'])[1];
            $group = LuckPermsClient::session()->groupRepository()->load($groupName);

            $userGroups->put($groupName, new UserGroup(
                $group->name(),
                $group->displayName(),
                $group->weight(),
                $group->metaData()->toArray(),
                $group->nodes()->map(function (Node $node) {
                    return $node->toArray();
                })->toArray(),
                $groupData['value'],
                $groupData['context'],
                $groupData['expiry'] ?? 0,
            ));
        }

        return $userGroups;
    }

    public static function mapSingle(array $data): UserGroup
    {
        return self::map($data)->first();
    }
}
