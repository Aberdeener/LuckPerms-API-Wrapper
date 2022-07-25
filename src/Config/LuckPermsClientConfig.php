<?php

namespace LuckPermsAPI\Config;

class LuckPermsClientConfig {

    public function __construct(
        readonly string $baseUri,
        readonly string $apiKey
    ) {
    }

}
