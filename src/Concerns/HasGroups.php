<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Group\Group;
use LuckPermsAPI\Group\GroupMapper;
use LuckPermsAPI\Node\NodeType;

trait HasGroups {

    /**
     * @return Collection<Group>
     */
    final public function groups(): Collection {
        return GroupMapper::map(collect($this->rawNodes)->filter(function (array $node) {
            return NodeType::of($node['type']) === NodeType::Inheritance;
        })->toArray());
    }

}
