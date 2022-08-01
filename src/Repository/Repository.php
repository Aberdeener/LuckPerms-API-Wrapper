<?php

namespace LuckPermsAPI\Repository;

use Illuminate\Support\Collection;
use LuckPermsAPI\Session;

/**
 * @template T
 */
abstract class Repository
{
    protected Session $session;
    protected Collection $objects;
    protected Collection $identifiers;

    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->objects = new Collection();
    }

    /**
     * @param string $identifier
     * @return T
     */
    abstract public function load(string $identifier);

    /**
     * @return Collection<T>
     */
    public function loadAll(): Collection
    {
        return $this->allIdentifiers()->map(function (string $identifier) {
            return $this->load($identifier);
        });
    }

    /**
     * @return Collection<string>
     */
    abstract public function allIdentifiers(): Collection;

    /**
     * @param Search $search
     * @return Collection<T>
     */
    abstract public function search(Search $search): Collection;

    final protected function json(string $body): array
    {
        return json_decode($body, true);
    }
}
