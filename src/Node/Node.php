<?php

namespace LuckPermsAPI\Node;

use Illuminate\Support\Collection;
use LuckPermsAPI\Context\Context;
use LuckPermsAPI\Context\ContextSetMapper;

class Node {

    private string $key;
    private NodeType $type;
    private string $value;
    private Collection $contextSet;

    public function __construct(
        string $key,
        string $type,
        string $value,
        array $context,
    ) {
        $this->key = $key;
        $this->type = NodeType::of($type);
        $this->value = $value;
        $this->contextSet = ContextSetMapper::map($context);
    }

    public function key(): string {
        return $this->key;
    }

    public function type(): NodeType {
        return $this->type;
    }

    public function value(): string {
        return $this->value;
    }

    /**
     * @return Collection<Context>
     */
    public function contextSet(): Collection {
        return $this->contextSet;
    }

}
