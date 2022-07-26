<?php

namespace LuckPermsAPI\Node;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;

class NodeMapper implements Mapper
{
    /**
     * @param array $data
     *
     * @return Collection<string, Node>
     */
    public static function map(array $data): Collection
    {
        $nodes = new Collection();

        foreach ($data as $nodeData) {
            $nodes->put($nodeData['key'], new Node(
                $nodeData['key'],
                NodeType::of($nodeData['type']),
                $nodeData['value'],
                $nodeData['context'],
                $nodeData['expiry'] ?? 0,
            ));
        }

        return $nodes;
    }

    public static function mapSingle(array $data): Node
    {
        return self::map($data)->first();
    }
}
