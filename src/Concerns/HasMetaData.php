<?php

namespace LuckPermsAPI\Concerns;

use LuckPermsAPI\MetaData\MetaData;
use LuckPermsAPI\MetaData\MetaDataMapper;

trait HasMetaData
{
    private array $metaData;

    final public function metaData(): MetaData
    {
        return resolve(MetaDataMapper::class)->map($this->metaData);
    }
}
