<?php

namespace LuckPermsAPI\Node;

use Illuminate\Support\Collection;
use LuckPermsAPI\Contracts\Mapper;
use LuckPermsAPI\Exception\InvalidNodeTypeException;
use RuntimeException;

class NodeMapper implements Mapper
{
    public function map(array $data): Node
    {
        return new Node(
            $data['key'],
            NodeType::tryFrom($data['type']) ?? throw new InvalidNodeTypeException("Invalid NodeType: {$data['type']}"),
            $data['value'],
            $data['context'],
            $data['expiry'] ?? 0,
        );
    }
}
