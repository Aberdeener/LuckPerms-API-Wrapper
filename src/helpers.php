<?php

use LuckPermsAPI\LuckPermsClient;

if (!function_exists('resolve')) {
    /**
     * @template T
     *
     * @param class-string<T> $className
     *
     * @return T
     */
    function resolve(string $className)
    {
        return LuckPermsClient::container()->make($className);
    }
}
