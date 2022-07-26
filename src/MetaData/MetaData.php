<?php

namespace LuckPermsAPI\MetaData;

use Illuminate\Support\Collection;

class MetaData {

    private Collection $meta;

    public function __construct(
        Collection $meta
    ) {
        $this->meta = $meta;
    }

    final public function meta(): Collection {
        return $this->meta;
    }

}
