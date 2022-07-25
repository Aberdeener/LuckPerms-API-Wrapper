<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use LuckPermsAPI\Context\Context;
use LuckPermsAPI\Context\ContextMapper;

trait HasContexts {

    private array $contexts;

    /**
     * @return Collection<Context>
     */
    final public function contexts(): Collection {
        return ContextMapper::map($this->contexts);
    }
}
