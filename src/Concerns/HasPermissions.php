<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeType;
use LuckPermsAPI\Permission\Permission;
use LuckPermsAPI\Permission\PermissionMapper;

trait HasPermissions
{
    /**
     * @return Collection<Permission>
     */
    final public function permissions(): Collection
    {
        return PermissionMapper::map($this->nodes()->filter(function (Node $node) {
            return $node->type() === NodeType::Permission;
        })->map(function (Node $node) {
            return $node->toArray();
        })->toArray());
    }
}
