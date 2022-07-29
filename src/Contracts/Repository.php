<?php

namespace LuckPermsAPI\Contracts;

use Illuminate\Support\Collection;
use LuckPermsAPI\Session;

abstract class Repository
{
    protected Session $session;
    protected Collection $objects;

    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->objects = new Collection();
    }

    abstract public function load(string $identifier);

    final protected function json(string $body): array
    {
        return json_decode($body, true);
    }
}
