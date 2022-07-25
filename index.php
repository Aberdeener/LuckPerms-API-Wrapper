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
    foreach ($node->contextSet() as $context) {
        echo $context->key() . '=' . $context->value();
    }
}

foreach ($user->groups() as $group) {
    echo $group->name();
    echo $group->displayName();
    echo $group->weight();
    foreach ($group->nodes() as $node) {
        echo $node->key() . ': ' . $node->value();
        foreach ($node->contextSet() as $context) {
            echo $context->key() . '=' . $context->value();
        }
    }
}
