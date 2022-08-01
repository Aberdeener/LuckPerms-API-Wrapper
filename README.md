# PHP LuckPerms REST API Client

## Examples

```php
<?php

use LuckPermsAPI\LuckPermsClient;
use LuckPermsAPI\Config\ConfigBuilder;
use LuckPermsAPI\Repository\Search;
use LuckPermsAPI\QueryOptions\QueryOptions;
use LuckPermsAPI\QueryOptions\QueryMode;
use LuckPermsAPI\QueryOptions\QueryFlag;
use LuckPermsAPI\Context\Context;
use LuckPermsAPI\Context\ContextKey;

$session = LuckPermsClient::make(
    ConfigBuilder::make()
        ->withApiKey('<your-api-key>')
        ->withBaseUri('<your-rest-api-url>')
        ->build()
);

// Get a user
$user = $session->userRepository()->load('<user-uuid>');

// Get all user UUIDs
$uuids = $session->userRepository()->allIdentifiers();

// Get a group
$group = $session->groupRepository()->load('<group-name>');

// Get all group names
$names = $session->groupRepository()->allIdentifiers();

// Search for a group (or user) with the `minecraft.command.ban` node key
$groups = $session->groupRepository()->search(Search::withKey('minecraft.command.ban'));

// Perform a permission check on a user (or group)
$permissionCheck = $user->hasPermission('permission.node');
if ($permissionCheck->result()) {
    // Yay!
    $node = $permissionCheck->node();
    echo "User has permission via node {$node->key()}";
}

// Apply QueryOptions to a permission check
$permissionCheck = $group->hasPermission(
    'permission.node',
    QueryOptions::make()
        ->setMode(QueryMode::Contextual)
        ->withFlag(QueryFlag::IncludeNodesWithoutServerContext)
        ->withContext(new Context(ContextKey::Dimension, 'nether'))
);
```
