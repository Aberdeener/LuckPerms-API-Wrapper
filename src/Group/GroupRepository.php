<?php

namespace LuckPermsAPI\Group;

use Illuminate\Support\LazyCollection;
use LuckPermsAPI\Contracts\Repository;
use LuckPermsAPI\Session;

class GroupRepository implements Repository {

    public static function get(Session $session): self {
        // TODO: Implement get() method.
    }

    public function all(): LazyCollection {
        // TODO: Implement all() method.
    }

    public function load(string $identifier): Group {
        // TODO: Implement get() method.
    }

}
