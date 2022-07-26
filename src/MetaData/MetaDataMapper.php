<?php

namespace LuckPermsAPI\MetaData;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;
use RuntimeException;

class MetaDataMapper implements Mapper
{
    public static function map(array $data): Collection
    {
        throw new RuntimeException('Not implemented');
    }

    public static function mapSingle(array $data): MetaData
    {
        return new MetaData(
            collect($data['meta']),
        );
    }
}
