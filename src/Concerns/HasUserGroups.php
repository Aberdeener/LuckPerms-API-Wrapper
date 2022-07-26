<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Group\UserGroup;
use LuckPermsAPI\Group\UserGroupMapper;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeType;

trait HasUserGroups
{
    /**
     * @return Collection<UserGroup>
     */
    final public function groups(): Collection
    {
        return UserGroupMapper::map($this->nodes()->filter(function (Node $node) {
            return $node->type() === NodeType::Inheritance;
        })->map(function (Node $node) {
            return $node->toArray();
        })->toArray());
    }
}
