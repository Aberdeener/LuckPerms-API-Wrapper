<?php

namespace LuckPermsAPI\Node;

enum NodeType: string
{
    case Inheritance = 'inheritance';
    case Permission = 'permission';
    case RegexPermission = 'regex_permission';
    case Prefix = 'prefix';
    case Suffix = 'suffix';
    case Meta = 'meta';
    case Weight = 'weight';
    case DisplayName = 'display_name';
}
