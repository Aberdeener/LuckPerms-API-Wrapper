<?php

namespace LuckPermsAPI\Node;

use LuckPermsAPI\Concerns\HasContexts;
use LuckPermsAPI\Concerns\HasExpiry;

class Node {

    use HasContexts;
    use HasExpiry;

    private string $key;
    private NodeType $type;
    private string $value;

    public function __construct(
        string $key,
        NodeType $type,
        string $value,
        array $contexts,
        int $expiry,
    ) {
        $this->key = $key;
        $this->type = $type;
        $this->value = $value;
        $this->contexts = $contexts;
        $this->expiry = $expiry;
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

    public function toArray(): array {
        return [
            'key' => $this->key,
            'type' => $this->type,
            'value' => $this->value,
            'context' => $this->contexts,
            'expiry' => $this->expiry,
        ];
    }
}
