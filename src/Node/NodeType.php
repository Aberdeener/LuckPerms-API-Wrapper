<?php

namespace LuckPermsAPI\Node;

enum NodeType {

    case Inheritance;
    case Permission;

    public static function of(string $type): NodeType {
        return match($type) {
            'inheritance' => self::Inheritance,
            'permission' => self::Permission,
            default => null,
        };
    }

}
