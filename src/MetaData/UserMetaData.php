<?php

namespace LuckPermsAPI\MetaData;

use Illuminate\Support\Collection;

class UserMetaData extends MetaData {

    private string $prefix;
    private string $suffix;
    private string $primaryGroup;

    public function __construct(
        string $prefix,
        string $suffix,
        string $primaryGroup,
        Collection $meta
    ) {
        parent::__construct($meta);
        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->primaryGroup = $primaryGroup;
    }

    final public function prefix(): string {
        return $this->prefix;
    }

    final public function suffix(): string {
        return $this->suffix;
    }

    final public function primaryGroup(): string {
        return $this->primaryGroup;
    }
}
