<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Node\NodeType;
use LuckPermsAPI\Permission\Permission;
use LuckPermsAPI\Permission\PermissionMapper;

trait HasPermissions {

    /**
     * @return Collection<Permission>
     */
    final public function permissions(): Collection {
        return PermissionMapper::map(collect($this->nodes)->filter(function(array $node) {
            return NodeType::of($node['type']) === NodeType::Permission;
        })->toArray());
    }
}
