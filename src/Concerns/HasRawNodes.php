<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeMapper;

trait HasRawNodes {

    private array $rawNodes;

    /**
     * @return Collection<Node>
     */
    final public function rawNodes(): Collection {
        return NodeMapper::map($this->rawNodes);
    }

}
