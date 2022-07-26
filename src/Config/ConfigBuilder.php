<?php

namespace LuckPermsAPI\Config;

class ConfigBuilder
{
    private string $baseUri;
    private string $apiKey;

    public static function make(): ConfigBuilder
    {
        return new self();
    }

    public function withBaseUri(string $baseUri): ConfigBuilder
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    public function withApiKey(string $apiKey): ConfigBuilder
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function build(): LuckPermsClientConfig
    {
        return new LuckPermsClientConfig($this->baseUri, $this->apiKey);
    }
}
