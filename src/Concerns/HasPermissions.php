<?php

namespace LuckPermsAPI\Concerns;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use LuckPermsAPI\Group\Group;
use LuckPermsAPI\LuckPermsClient;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeMapper;
use LuckPermsAPI\Node\NodeType;
use LuckPermsAPI\Permission\Permission;
use LuckPermsAPI\Permission\PermissionCheckResult;
use LuckPermsAPI\Permission\PermissionMapper;
use LuckPermsAPI\QueryOptions\QueryOptions;
use LuckPermsAPI\User\User;

trait HasPermissions
{
    /**
     * @return Collection<Permission>
     */
    final public function permissions(): Collection
    {
        $permissionMapper = resolve(PermissionMapper::class);

        return $this->nodes()
            ->filter(function (Node $node) {
                return $node->type() === NodeType::Permission;
            })->map(function (Node $node) use ($permissionMapper): Permission {
                return $permissionMapper->map($node->toArray());
            });
    }

    final public function hasPermission(string $permission, QueryOptions $queryOptions = null): PermissionCheckResult {
        $route = $this->findRoute();
        $httpClient = LuckPermsClient::session()->httpClient;

        if ($queryOptions !== null) {
            $response = $httpClient->post($route, [
                'json' => [
                    $this->identifierMethod() => $this->identifier(),
                    'permission' => $permission,
                    'queryOptions' => $queryOptions->toArray(),
                ],
            ]);
        } else {
            $response = $httpClient->get($route, [
                'json' => [
                    $this->identifierMethod() => $this->identifier(),
                    'permission' => $permission,
                ],
            ]);
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return new PermissionCheckResult(
            $data['result'],
            resolve(NodeMapper::class)->map($data['node']),
        );
    }

    private function findRoute(): string
    {
        $prefix = match(static::class) {
            User::class => 'user',
            Group::class => 'group',
            default => throw new InvalidArgumentException('Unsupported subclass'),
        };

        $identifier = $this->identifier();

        return "/{$prefix}/{$identifier}/permissionCheck";
    }

    private function identifierMethod(): string
    {
        return match(static::class) {
            User::class => 'uniqueId',
            Group::class => 'name',
            default => throw new InvalidArgumentException('Unsupported subclass'),
        };
    }

    private function identifier(): string
    {
        $identifierMethod = $this->identifierMethod();
        return $this->{$identifierMethod}();
    }
}
