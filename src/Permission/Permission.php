<?php

namespace LuckPermsAPI\Permission;

use LuckPermsAPI\Concerns\HasContexts;

class Permission
{
    use HasContexts;

    private string $name;
    private string $value;

    public function __construct(
        string $name,
        string $value,
        array $contexts,
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->contexts = $contexts;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): bool
    {
        return $this->value === 'true';
    }
}
