<?php

namespace LuckPermsAPI\Context;

use LuckPermsAPI\Contracts\Mapper;

class ContextMapper implements Mapper
{
    public function map(array $data): Context
    {
        return new Context(
            ContextKey::from($data['key']),
            $data['value'],
        );
    }
}
