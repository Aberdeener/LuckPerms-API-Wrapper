<?php

namespace LuckPermsAPI\Permission;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;

class PermissionMapper implements Mapper
{
    /**
     * @param array $data
     *
     * @return Collection<Permission>
     */
    public static function map(array $data): Collection
    {
        $permissions = new Collection();

        foreach ($data as $permissionData) {
            $permissions->push(new Permission(
                $permissionData['key'],
                $permissionData['value'],
                $permissionData['context'],
            ));
        }

        return $permissions;
    }

    public static function mapSingle(array $data): Permission
    {
        return self::map($data)->first();
    }
}
