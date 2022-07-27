<?php

namespace LuckPermsAPI\Context;

enum ContextKey: string
{
    case Server = 'server';
    case World = 'world';
    case GameMode = 'gamemode';
    case Dimension = 'dimension';
    case Proxy = 'proxy';
}
