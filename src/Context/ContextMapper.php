<?php

namespace LuckPermsAPI\Context;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;

class ContextMapper implements Mapper {

    /**
     * @param array $data
     * @return Collection<Context>
     */
    public static function map(array $data): Collection {
        $contexts = new Collection();

        foreach ($data as $contextData) {
            $contexts->push(new Context(
                ContextKey::of($contextData['key']),
                $contextData['value'],
            ));
        }

        return $contexts;
    }

    public static function mapSingle(array $data): Context {
        return self::map($data)->first();
    }
}
