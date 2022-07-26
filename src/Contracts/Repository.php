<?php

namespace LuckPermsAPI\Contracts;

use Illuminate\Support\Collection;
use LuckPermsAPI\Session;

abstract class Repository
{
    protected Session $session;
    private static Repository $instance;
    protected Collection $objects;

    private function __construct(Session $session)
    {
        $this->session = $session;
        $this->objects = new Collection();
    }

    final public static function get(Session $session): static
    {
        return self::$instance ??= new static($session);
    }

    abstract public function load(string $identifier);
}
