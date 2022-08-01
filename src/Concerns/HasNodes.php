<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeMapper;

trait HasNodes
{
    private array $nodes;

    /**
     * @return Collection<Node>
     */
    final public function nodes(): Collection
    {
        $nodeMapper = resolve(NodeMapper::class);

        return collect($this->nodes)
            ->map(function (array $node) use ($nodeMapper): Node {
                return $nodeMapper->map($node);
            });
    }
}
