<?php

namespace LuckPermsAPI\Contracts;

use Illuminate\Support\Collection;

interface Mapper {

    public static function map(array $data): Collection;

}
