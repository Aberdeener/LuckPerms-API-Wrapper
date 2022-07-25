<?php

namespace LuckPermsAPI\Context;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;

class ContextSetMapper implements Mapper {

    /**
     * @param array $data
     * @return Collection<string, Context>
     */
    public static function map(array $data): Collection {
        $contextSet = new Collection();

        foreach ($data as $contextData) {
            $context = new Context(
                $contextData['key'],
                $contextData['value'],
            );
            $contextSet->push($context);
        }

        return $contextSet;
    }

}
