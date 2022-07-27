<?php

namespace LuckPermsAPI\Node;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;
use LuckPermsAPI\Exception\InvalidNodeTypeException;
use RuntimeException;

class NodeMapper implements Mapper
{
    /**
     * @param array $data
     *
     * @throws InvalidNodeTypeException
     *
     * @return Collection<string, Node>
     */
    public static function map(array $data): Collection
    {
        $nodes = new Collection();

        foreach ($data as $nodeData) {
            $nodes->put($nodeData['key'], new Node(
                $nodeData['key'],
                NodeType::tryFrom($nodeData['type']) ?? throw new InvalidNodeTypeException("Invalid NodeType: {$nodeData['type']}"),
                $nodeData['value'],
                $nodeData['context'],
                $nodeData['expiry'] ?? 0,
            ));
        }

        return $nodes;
    }

    public static function mapSingle(array $data): Node
    {
        throw new RuntimeException('Not implemented');
    }
}
