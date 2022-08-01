<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Group\Group;
use LuckPermsAPI\Group\GroupMapper;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeType;

trait HasGroups
{
    /**
     * @return Collection<Group>
     */
    final public function groups(): Collection
    {
        $groupMapper = resolve(GroupMapper::class);

        return $this->nodes()
            ->filter(function (Node $node) {
                return $node->type() === NodeType::Inheritance;
            })->map(function (Node $node) use ($groupMapper): Group {
                return $groupMapper->map($node->toArray());
            });
    }
}
