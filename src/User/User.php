<?php

namespace LuckPermsAPI\User;

use Illuminate\Support\Collection;
use LuckPermsAPI\Group\Group;
use LuckPermsAPI\Group\GroupMapper;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeMapper;
use LuckPermsAPI\Node\NodeType;
use LuckPermsAPI\Permission\Permission;
use LuckPermsAPI\Permission\PermissionMapper;

class User {

    private string $username;
    private string $uniqueId;
    private array $rawNodes;

    private Collection $nodes;

    public function __construct(array $user) {
        $this->username = $user['username'];
        $this->uniqueId = $user['uniqueId'];
        $this->rawNodes = $user['nodes'];
    }

    public function username(): string {
        return $this->username;
    }

    public function uniqueId(): string {
        return $this->uniqueId;
    }

    /**
     * @return Collection<Node>
     */
    public function rawNodes(): Collection {
        if (isset($this->nodes)) {
            return $this->nodes;
        }

        return $this->nodes = NodeMapper::map($this->rawNodes);
    }

    /**
     * @return Collection<Group>
     */
    public function groups(): Collection {
        return GroupMapper::map($this->rawNodes()->filter(function(Node $node) {
            return $node->type() === NodeType::Inheritance;
        })->toArray());
    }

    /**
     * @return Collection<Permission>
     */
    public function permissions(): Collection {
        return PermissionMapper::map($this->rawNodes()->filter(function(Node $node) {
            return $node->type() === NodeType::Permission;
        })->toArray());
    }

}
