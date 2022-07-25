<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeMapper;

trait HasNodes {

    private array $nodes;

    /**
     * @return Collection<Node>
     */
    final public function nodes(): Collection {
        return NodeMapper::map($this->nodes);
    }
}
