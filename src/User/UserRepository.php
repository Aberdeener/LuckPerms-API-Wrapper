<?php

namespace LuckPermsAPI\User;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use LuckPermsAPI\Contracts\Repository;
use LuckPermsAPI\Session;

class UserRepository implements Repository {

    private Session $session;
    private static UserRepository $instance;
    private Collection $users;

    private function __construct(Session $session) {
        $this->session = $session;
        $this->users = new Collection();
    }

    public static function get(Session $session): self {
        return self::$instance ??= new self($session);
    }

    /**
     * @return LazyCollection<User>
     */
    public function all(): LazyCollection {
        return $this->users->lazy();
    }

    public function load(string $identifier): ?User {
        if ($this->users->has($identifier)) {
            return $this->users->get($identifier);
        }

        $response = $this->session->httpClient->get("/users/{$identifier}");

        $data = json_decode($response->getBody()->getContents(), true);

        $this->users->put($data['uniqueId'], $user = new User($data));

        return $user;
    }

}
