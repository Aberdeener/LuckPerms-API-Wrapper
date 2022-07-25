<?php

namespace LuckPermsAPI\Node;

use LuckPermsAPI\Exception\InvalidNodeTypeException;

enum NodeType {

    case Inheritance;
    case Permission;

    public static function of(string $type): NodeType {
        return match($type) {
            'inheritance' => self::Inheritance,
            'permission' => self::Permission,
            default => throw new InvalidNodeTypeException("Invalid NodeType: {$type}"),
        };
    }

}
