<?php

namespace LuckPermsAPI\Group;

use Illuminate\Support\Collection;
use LuckPermsAPI\Node\Node;

class Group {

    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function name(): string {
        return $this->name;
    }

    public function displayName(): string {

    }

    public function weight(): int {

    }

    public function metadata(): array {

    }

    /**
     * @return Collection<Node>
     */
    public function nodes(): Collection {

    }

}
