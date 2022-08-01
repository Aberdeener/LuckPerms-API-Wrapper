<?php

namespace LuckPermsAPI\MetaData;

use LuckPermsAPI\Contracts\Mapper;

class UserMetaDataMapper implements Mapper
{
    public function map(array $data): UserMetaData
    {
        return new UserMetaData(
            $data['prefix'],
            $data['suffix'],
            $data['primaryGroup'],
            collect($data['meta']),
        );
    }
}
