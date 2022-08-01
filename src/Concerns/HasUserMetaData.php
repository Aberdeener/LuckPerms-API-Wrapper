<?php

namespace LuckPermsAPI\Concerns;

use LuckPermsAPI\MetaData\UserMetaData;
use LuckPermsAPI\MetaData\UserMetaDataMapper;

trait HasUserMetaData
{
    private array $metaData;

    final public function metaData(): UserMetaData
    {
        return resolve(UserMetaDataMapper::class)->map($this->metaData);
    }
}
