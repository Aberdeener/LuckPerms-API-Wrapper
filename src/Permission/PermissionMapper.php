<?php

namespace LuckPermsAPI\Permission;

use LuckPermsAPI\Contracts\Mapper;

class PermissionMapper implements Mapper
{
    public function map(array $data): Permission
    {
        return new Permission(
            $data['key'],
            $data['value'],
            $data['context'],
        );
    }
}
