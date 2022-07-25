<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Group\Group;
use LuckPermsAPI\Group\GroupMapper;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeType;

trait HasGroups {

    /**
     * @return Collection<Group>
     */
    final public function groups(): Collection {
        return GroupMapper::map($this->nodes()->filter(function (Node $node) {
            return $node->type() === NodeType::Inheritance;
        })->map(function (Node $node) {
            return $node->toArray();
        })->toArray());
    }
}
