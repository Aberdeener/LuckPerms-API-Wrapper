<?php

namespace LuckPermsAPI\Permission;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;
use LuckPermsAPI\Node\Node;

class PermissionMapper implements Mapper {

    /**
     * @param Node[] $data
     * @return Collection<Permission>
     */
    public static function map(array $data): Collection {
        $permissions = new Collection();

        foreach ($data as $permissionData) {
            $permissions->push(new Permission($permissionData->key(), $permissionData->value()));
        }

        return $permissions;
    }
}
