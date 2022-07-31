<?php

namespace Tests\User;

use GuzzleHttp\Psr7\Response;
use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Exception\UserNotFoundException;
use LuckPermsAPI\Group\UserGroup;
use LuckPermsAPI\Node\NodeType;
use LuckPermsAPI\Permission\Permission;
use LuckPermsAPI\User\UserMapper;
use Tests\TestCase;

class UserRepositoryTest extends TestCase {

    public function test_load_will_throw_exception_if_user_not_found(): void {
        $this->session->httpClient = $this->createMockClient([
            new Response(404),
        ]);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("User with identifier 'not-a-uuid' not found");

        $this->session->userRepository()->load('not-a-uuid');
    }

    public function test_load_will_not_call_api_twice(): void {
        $this->session->httpClient = $this->createMockClient([
            new Response(200, [], json_encode([
                'uniqueId' => '9490b898-856a-4aae-8de3-2986d007269b',
                'username' => 'Aberdeener',
                'nodes' => [
                    [
                        'key' => 'group.staff',
                        'type' => 'inheritance',
                        'value' => 'true',
                        'context' => [
                            [
                                'key' => 'world',
                                'value' => 'survival',
                            ],
                        ],
                    ],
                    [
                        'key' => 'group.member',
                        'type' => 'inheritance',
                        'value' => 'true',
                        'context' => [],
                        'expiry' => 1111111111,
                    ],
                    [
                        'key' => 'minecraft.command.ban',
                        'type' => 'permission',
                        'value' => 'true',
                        'context' => [
                            [
                                'key' => 'server',
                                'value' => 'lobby',
                            ],
                        ],
                    ],
                ],
                'metaData' => [
                    'meta' => [
                        'test' => 'test value',
                    ],
                    'prefix' => 'prefix!',
                    'suffix' => 'suffix!',
                    'primaryGroup' => 'staff',
                ],
            ], JSON_THROW_ON_ERROR)),
        ]);

        $userMapperMock = $this->createMock(UserMapper::class);
        $this->container->singleton(UserMapper::class, fn() => $userMapperMock);

        $userMapperMock->expects($this->once())->method('mapSingle');

        $this->session->userRepository()->load('9490b898-856a-4aae-8de3-2986d007269b');
        $this->session->userRepository()->load('9490b898-856a-4aae-8de3-2986d007269b');
    }

    public function test_load_will_return_user_if_valid() {
        $this->session->httpClient = $this->createMockClient([
            new Response(200, [], json_encode([
                'uniqueId' => '9490b898-856a-4aae-8de3-2986d007269b',
                'username' => 'Aberdeener',
                'nodes' => [
                    [
                        'key' => 'group.staff',
                        'type' => 'inheritance',
                        'value' => 'true',
                        'context' => [
                            [
                                'key' => 'world',
                                'value' => 'survival',
                            ],
                        ],
                    ],
                    [
                        'key' => 'group.member',
                        'type' => 'inheritance',
                        'value' => 'true',
                        'context' => [],
                        'expiry' => 1111111111,
                    ],
                    [
                        'key' => 'minecraft.command.ban',
                        'type' => 'permission',
                        'value' => 'true',
                        'context' => [
                            [
                                'key' => 'server',
                                'value' => 'lobby',
                            ],
                        ],
                    ],
                ],
                'metaData' => [
                    'meta' => [
                        'test' => 'test value',
                    ],
                    'prefix' => 'prefix!',
                    'suffix' => 'suffix!',
                    'primaryGroup' => 'staff',
                ],
            ], JSON_THROW_ON_ERROR)),
            new Response(200, [], json_encode([
                'name' => 'staff',
                'displayName' => 'Staff',
                'weight' => 1,
                'metaData' => [
                    'meta' => [
                        'test' => 'test staff value',
                    ],
                ],
                'nodes' => [
                    [
                        'key' => 'group.helper',
                        'type' => 'inheritance',
                        'value' => 'true',
                        'context' => [
                            [
                                'key' => 'world',
                                'value' => 'survival',
                            ],
                        ],
                    ],
                    [
                        'key' => 'multiverse.*',
                        'type' => 'permission',
                        'value' => 'true',
                        'context' => [],
                    ]
                ]
            ], JSON_THROW_ON_ERROR)),
            new Response(200, [], json_encode([
                'name' => 'member',
                'displayName' => 'Meember!',
                'weight' => 5,
                'metaData' => [
                    'meta' => [
                        'test' => 'test meember value',
                    ],
                ],
                'nodes' => []
            ], JSON_THROW_ON_ERROR))
        ]);

        $user = $this->session->userRepository()->load('9490b898-856a-4aae-8de3-2986d007269b');

        $this->assertSame('9490b898-856a-4aae-8de3-2986d007269b', $user->uniqueId());
        $this->assertSame('Aberdeener', $user->username());

        $this->assertCount(3, $user->nodes());

        $this->assertCount(2, $user->groups());
        $group = $user->groups()->first();
        $this->assertInstanceOf(UserGroup::class, $group);
        $this->assertSame('staff', $group->name());
        $this->assertSame('Staff', $group->displayName());
        $this->assertTrue($group->value());
        $this->assertCount(1, $group->contexts());
        $this->assertSame(ContextKey::World, $group->contexts()->first()->key());
        $this->assertSame('survival', $group->contexts()->first()->value());
        $this->assertCount(2, $group->nodes());
        $this->assertCount(1, $group->permissions());
        $this->assertSame('group.helper', $group->nodes()->first()->key());
        $this->assertSame(NodeType::Inheritance, $group->nodes()->first()->type());
        $this->assertSame('true', $group->nodes()->first()->value());
        $this->assertCount(1, $group->nodes()->first()->contexts());
        $this->assertSame(ContextKey::World, $group->nodes()->first()->contexts()->first()->key());
        $this->assertSame('survival', $group->nodes()->first()->contexts()->first()->value());
        $this->assertSame('multiverse.*', $group->permissions()->first()->name());
        $this->assertSame(NodeType::Permission, $group->nodes()->last()->type());
        $this->assertTrue($group->permissions()->first()->value());
        $this->assertCount(0, $group->permissions()->first()->contexts());

        $group = $user->groups()->last();
        $this->assertInstanceOf(UserGroup::class, $group);
        $this->assertSame('member', $group->name());
        $this->assertSame('Meember!', $group->displayName());
        $this->assertTrue($group->value());
        $this->assertCount(0, $group->contexts());
        $this->assertSame(1111111111, $group->expiry());

        $this->assertCount(1, $user->permissions());
        $this->assertInstanceOf(Permission::class, $user->permissions()->first());
        $this->assertSame('minecraft.command.ban', $user->permissions()->first()->name());
        $this->assertTrue($user->permissions()->first()->value());
        $this->assertCount(1, $user->permissions()->first()->contexts());
        $this->assertSame(ContextKey::Server, $user->permissions()->first()->contexts()->first()->key());
        $this->assertSame('lobby', $user->permissions()->first()->contexts()->first()->value());

        $this->assertCount(1, $user->metaData()->meta());
        $this->assertSame('test value', $user->metaData()->meta()->get('test'));
        $this->assertSame('prefix!', $user->metaData()->prefix());
        $this->assertSame('suffix!', $user->metaData()->suffix());
        $this->assertSame('staff', $user->metaData()->primaryGroup());
    }

}
