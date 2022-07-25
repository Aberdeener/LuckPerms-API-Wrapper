<?php

use LuckPermsAPI\Config\ConfigBuilder;
use LuckPermsAPI\Exception\LuckPermsConnectionException;
use LuckPermsAPI\LuckPermsClient;

$session = null;
try {
    $session = LuckPermsClient::make(
        ConfigBuilder::make()
            ->withBaseUri('https://luckperms.com/api/v2/')
            ->withApiKey('<your-api-key>')
            ->build()
    );
} catch (LuckPermsConnectionException $e) {
    echo "Could not connect to LuckPerms API: {$e->getMessage()}";
}

$user = $session->userRepository()->load('Aberdeener');

foreach ($user->nodes() as $node) {
    echo $node->key() . ': ' . $node->value();
    echo $node->expiry();
    foreach ($node->contexts() as $context) {
        echo $context->key()->name . '=' . $context->value();
    }
}

foreach ($user->groups() as $group) {
    echo $group->name();
    echo $group->displayName();
    echo $group->weight();
    echo $group->permissions();
    echo $group->contexts();
    echo $group->expiry();
    foreach ($group->nodes() as $node) {
        echo $node->key() . ': ' . $node->value();
        foreach ($node->contexts() as $context) {
            echo $context->key()->name . '=' . $context->value();
        }
    }
}

$group = $session->groupRepository()->load('Admin');
echo $group->name();
echo $group->displayName();
echo $group->weight();
echo $group->permissions();
foreach ($group->nodes() as $node) {
    echo $node->key() . ': ' . $node->value();
    foreach ($node->contexts() as $context) {
        echo $context->key()->name . '=' . $context->value();
    }
}
