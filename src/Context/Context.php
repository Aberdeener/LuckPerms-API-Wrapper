<?php

namespace LuckPermsAPI\Context;

class Context {

    private ContextKey $key;
    private string $value;

    public function __construct(string $key, string $value) {
        $this->key = ContextKey::of($key);
        $this->value = $value;
    }

    public function key(): ContextKey {
        return $this->key;
    }

    public function value(): string {
        return $this->value;
    }

}
