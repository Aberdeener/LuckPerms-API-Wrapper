<?php

namespace LuckPermsAPI\Contracts;

use Illuminate\Support\LazyCollection;
use LuckPermsAPI\Session;

interface Repository {

    public static function get(Session $session): self;

    public function all(): LazyCollection;

    public function load(string $identifier);

}
