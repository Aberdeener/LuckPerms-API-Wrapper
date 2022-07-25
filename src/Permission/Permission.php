<?php

namespace LuckPermsAPI\Permission;

use Illuminate\Support\Collection;
use LuckPermsAPI\Context\Context;

class Permission {

    private string $name;
    private string $value;
    private Collection $contextSet;

    public function __construct(string $name, string $value, Collection $contextSet) {
        $this->name = $name;
        $this->value = $value;
        $this->contextSet = $contextSet;
    }

    public function name(): string {
        return $this->name;
    }

    public function value(): bool {
        return $this->value;
    }

    /**
     * @return Collection<Context>
     */
    public function contextSet(): Collection {
        return $this->contextSet;
    }

}
