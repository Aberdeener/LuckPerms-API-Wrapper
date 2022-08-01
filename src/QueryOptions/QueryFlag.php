<?php

namespace LuckPermsAPI\QueryOptions;

enum QueryFlag: string
{
    case ResolveInheritance = 'resolve_inheritance';
    case IncludeNodesWithoutServerContext = 'include_nodes_without_server_context';
    case IncludeNodesWithoutWorldContext = 'include_nodes_without_world_context';
    case ApplyInheritanceNodesWithoutServerContext = 'apply_inheritance_nodes_without_server_context';
    case ApplyInheritanceNodesWithoutWorldContext = 'apply_inheritance_nodes_without_world_context';
}
