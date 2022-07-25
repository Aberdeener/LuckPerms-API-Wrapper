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
            $groupName = explode('.', $groupData['key'])[1];
            $userGroups->put($groupName, GroupRepository::get(null)->load($groupName)->toUserGroup(
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
