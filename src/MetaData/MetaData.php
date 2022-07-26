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

    public function meta(): Collection {
        return $this->meta;
    }

    public function toArray(): array {
        return [
            'meta' => $this->meta->toArray()
        ];
    }

}
