<?php

namespace LuckPermsAPI\Node;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;

class NodeMapper implements Mapper {

    /**
     * @param array $data
     * @return Collection<string, Node>
     */
    public static function map(array $data): Collection {
        $nodes = new Collection();

        foreach ($data as $nodeData) {
            $node = new Node(
                $nodeData['key'],
                $nodeData['type'],
                $nodeData['value'],
                $nodeData['context'],
            );
            $nodes->put($nodeData['key'], $node);
        }

        return $nodes;
    }

}
