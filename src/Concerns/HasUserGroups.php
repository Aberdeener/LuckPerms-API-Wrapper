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
        $userGroupMapper = resolve(UserGroupMapper::class);

        return $this->nodes()
            ->filter(function (Node $node) {
                return $node->type() === NodeType::Inheritance;
            })
            ->map(function (Node $node) use ($userGroupMapper): UserGroup {
                return $userGroupMapper->map($node->toArray());
            });
    }
}
