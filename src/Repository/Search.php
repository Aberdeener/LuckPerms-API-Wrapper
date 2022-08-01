<?php

namespace LuckPermsAPI\Repository;

use LuckPermsAPI\Node\NodeType;

class Search
{
    private readonly string $method;
    private readonly string $value;

    private function __construct(string $method, string $value)
    {
        $this->method = $method;
        $this->value = $value;
    }

    public static function withKey(string $key): Search
    {
        return new Search('key', $key);
    }

    public static function withKeyStartsWith(string $key): Search
    {
        return new Search('keyStartsWith', $key);
    }

    public static function withMetaKey(string $key): Search
    {
        return new Search('metaKey', $key);
    }

    public static function withType(NodeType $type): Search
    {
        return new Search('type', $type->value);
    }

    public function toArray(): array
    {
        return [
            $this->method => $this->value,
        ];
    }
}
