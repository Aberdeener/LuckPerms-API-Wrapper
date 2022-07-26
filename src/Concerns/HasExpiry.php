<?php

namespace LuckPermsAPI\Concerns;

trait HasExpiry
{
    private int $expiry;

    final public function expiry(): int
    {
        return $this->expiry;
    }
}
