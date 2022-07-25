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
        return PermissionMapper::map(collect($this->rawNodes)->filter(function(array $node) {
            return $node['type'] === mb_strtolower(NodeType::Permission->name); // yuck
        })->toArray());
    }
}
