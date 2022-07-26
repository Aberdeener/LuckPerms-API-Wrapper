<?php

namespace LuckPermsAPI\Context;

enum ContextKey
{
    case Server;
    case World;
    case GameMode;
    case Dimension;
    case Proxy;

    public static function of(string $key): ContextKey
    {
        return match ($key) {
            'server' => self::Server,
            'world' => self::World,
            'gamemode' => self::GameMode,
            'dimension' => self::Dimension,
            'proxy' => self::Proxy,
            default => null, // returning null as custom context keys are allowed... not sure how to handle
        };
    }
}
