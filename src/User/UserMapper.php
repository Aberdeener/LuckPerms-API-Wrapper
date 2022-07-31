<?php

namespace LuckPermsAPI\User;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;
use RuntimeException;

class UserMapper implements Mapper {

    public function map(array $data): Collection {
        throw new RuntimeException('Not implemented');
    }

    public function mapSingle(array $data): User {
        return new User(
            $data['username'],
            $data['uniqueId'],
            $data['nodes'],
            $data['metaData'],
        );
    }
}
