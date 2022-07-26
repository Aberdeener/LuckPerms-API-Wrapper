<?php

namespace LuckPermsAPI\MetaData;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;
use RuntimeException;

class UserMetaDataMapper implements Mapper {

    public static function map(array $data): Collection {
        throw new RuntimeException('Not implemented');
    }

    public static function mapSingle(array $data): UserMetaData {
        return new UserMetaData(
            $data['prefix'],
            $data['suffix'],
            $data['primaryGroup'],
            collect($data['meta']),
        );
    }
}
