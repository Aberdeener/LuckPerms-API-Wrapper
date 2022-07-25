<?php

namespace LuckPermsAPI\User;

use Illuminate\Support\Collection;
use LuckPermsAPI\Concerns\HasPermissions;
use LuckPermsAPI\Concerns\HasRawNodes;
use LuckPermsAPI\Concerns\HasUserGroups;

class User {

    use HasRawNodes;
    use HasPermissions;
    use HasUserGroups;

    private string $username;
    private string $uniqueId;

    private Collection $nodes;

    public function __construct(
        string $username,
        string $uniqueId,
        array $nodes,
    ) {
        $this->username = $username;
        $this->uniqueId = $uniqueId;
        $this->rawNodes = $nodes;
    }

    public function username(): string {
        return $this->username;
    }

    public function uniqueId(): string {
        return $this->uniqueId;
    }
}
