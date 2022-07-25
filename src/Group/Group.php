<?php

namespace LuckPermsAPI\Group;

use LuckPermsAPI\Concerns\HasPermissions;
use LuckPermsAPI\Concerns\HasNodes;

class Group {

    use HasNodes;
    use HasPermissions;

    private string $name;
    private string $displayName;
    private int $weight;
    private array $metadata;

    public function __construct(
        string $name,
        string $displayName,
        int $weight,
        array $metadata,
        array $nodes,
    ) {
        $this->name = $name;
        $this->displayName = $displayName;
        $this->weight = $weight;
        $this->metadata = $metadata;
        $this->nodes = $nodes;
    }

    public function name(): string {
        return $this->name;
    }

    public function displayName(): string {
        return $this->displayName;
    }

    public function weight(): int {
        return $this->weight;
    }

    public function metadata(): array {
        return $this->metadata;
    }

    public function toUserGroup(array $contexts, int $expiry): UserGroup {
        return new UserGroup(
            $this->name(),
            $this->displayName(),
            $this->weight(),
            $this->metadata(),
            $this->nodes(),
            $contexts,
            $expiry,
        );
    }
}
