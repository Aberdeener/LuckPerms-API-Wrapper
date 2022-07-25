<?php

namespace LuckPermsAPI\Group;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;

class GroupMapper implements Mapper {

    /**
     * @param array $data
     * @return Collection<Group>
     */
    public static function map(array $data): Collection {
        $groups = new Collection();

        foreach ($data as $groupData) {
            $groups->put($groupData['name'], new Group(
                $groupData['name'],
                $groupData['displayName'],
                $groupData['weight'],
                $groupData['metadata'],
                $groupData['nodes'],
            ));
        }

        return $groups;
    }

    /**
     * @param array $data
     * @return Group
     */
    public static function mapSingle(array $data): Group {
        return self::map($data)->first();
    }
}
