<?php

namespace LuckPermsAPI\Contracts;

use Illuminate\Support\Collection;

interface Mapper
{
    public function map(array $data): Collection;

    public function mapSingle(array $data);
}
