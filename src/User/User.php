<?php

namespace LuckPermsAPI\User;

use LuckPermsAPI\Concerns\HasPermissions;
use LuckPermsAPI\Concerns\HasNodes;
use LuckPermsAPI\Concerns\HasUserGroups;

class User {

    use HasNodes;
    use HasPermissions;
    use HasUserGroups;

    private string $username;
    private string $uniqueId;

    public function __construct(
        string $username,
        string $uniqueId,
        array $nodes,
    ) {
        $this->username = $username;
        $this->uniqueId = $uniqueId;
        $this->nodes = $nodes;
    }

    public function username(): string {
        return $this->username;
    }

    public function uniqueId(): string {
        return $this->uniqueId;
    }
}
