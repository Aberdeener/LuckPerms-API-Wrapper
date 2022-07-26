<?php

namespace LuckPermsAPI\Group;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;

class UserGroupMapper implements Mapper {

    /**
     * @param array $data
     * @return Collection<UserGroup>
     */
    public static function map(array $data): Collection {
        $userGroups = new Collection();

        foreach ($data as $groupData) {
            $groupName = explode('group.', $groupData['key'])[1];
            $group = GroupRepository::get(null)->load($groupName);

            $userGroups->put($groupName, new UserGroup(
                $group->name(),
                $group->displayName(),
                $group->weight(),
                $group->metadata(),
                $group->nodes(),
                $groupData['context'],
                $groupData['expiry'] ?? 0,
            ));
        }

        return $userGroups;
    }

    public static function mapSingle(array $data): UserGroup {
        return self::map($data)->first();
    }
}
