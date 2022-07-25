<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Group\UserGroup;
use LuckPermsAPI\Group\UserGroupMapper;
use LuckPermsAPI\Node\NodeType;

trait HasUserGroups {

    /**
     * @return Collection<UserGroup>
     */
    final public function groups(): Collection {
        return UserGroupMapper::map(collect($this->nodes)->filter(function (array $node) {
            return $node['type'] === mb_strtolower(NodeType::Inheritance->name); // yuck
        })->toArray());
    }

}
