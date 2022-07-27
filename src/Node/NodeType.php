<?php

namespace LuckPermsAPI\Node;

enum NodeType: string
{
    case Inheritance = 'inheritance';
    case Permission = 'permission';
}
