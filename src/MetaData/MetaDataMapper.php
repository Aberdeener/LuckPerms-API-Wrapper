<?php

namespace LuckPermsAPI\MetaData;

use LuckPermsAPI\Contracts\Mapper;

class MetaDataMapper implements Mapper
{
    public function map(array $data): MetaData
    {
        return new MetaData(
            collect($data['meta']),
        );
    }
}
