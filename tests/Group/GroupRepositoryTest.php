<?php

namespace Tests\Group;

use GuzzleHttp\Psr7\Response;
use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Exception\GroupNotFoundException;
use LuckPermsAPI\Group\GroupMapper;
use LuckPermsAPI\LuckPermsClient;
use LuckPermsAPI\Node\NodeType;
use Tests\TestCase;

class GroupRepositoryTest extends TestCase {

    public function test_load_will_throw_exception_if_group_not_found(): void {
        $this->session->httpClient = $this->createMockClient([
            new Response(404),
        ]);

        $this->expectException(GroupNotFoundException::class);
        $this->expectExceptionMessage("Group with name 'not-a-group' not found");

        $this->session->groupRepository()->load('not-a-group');
    }

    public function test_load_will_return_group_if_valid(): void {
        $this->session->httpClient = $this->createMockClient([
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
        ]);

        $group = $this->session->groupRepository()->load('staff');

        $this->assertSame('staff', $group->name());
        $this->assertSame('Staff', $group->displayName());
        $this->assertSame(1, $group->weight());
        $this->assertCount(1, $group->metaData()->meta());
        $this->assertSame('test staff value', $group->metaData()->meta()->get('test'));
        $this->assertSame([
            'meta' => [
                'test' => 'test staff value',
            ],
        ], $group->metaData()->toArray());
        $this->assertCount(2, $group->nodes());
        $this->assertSame('group.helper', $group->nodes()->first()->key());
        $this->assertSame(NodeType::Inheritance, $group->nodes()->first()->type());
        $this->assertSame('inheritance', $group->nodes()->first()->type()->value);
        $this->assertSame('true', $group->nodes()->first()->value());
        $this->assertSame(ContextKey::World, $group->nodes()->first()->contexts()->first()->key());
        $this->assertSame('survival', $group->nodes()->first()->contexts()->first()->value());
        $this->assertSame('multiverse.*', $group->nodes()->last()->key());
        $this->assertSame(NodeType::Permission, $group->nodes()->last()->type());
        $this->assertSame('permission', $group->nodes()->last()->type()->value);
        $this->assertSame('true', $group->nodes()->last()->value());
        $this->assertCount(0, $group->nodes()->last()->contexts());
    }

    public function test_load_will_not_call_api_twice(): void {
        $this->session->httpClient = $this->createMockClient([
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
        ]);

        // expect GroupMapper->mapSingle to be called only once, since it'll be cached the second time
        $groupMapperMock = $this->createMock(GroupMapper::class);
        $this->container->singleton(GroupMapper::class, fn() => $groupMapperMock);

        $groupMapperMock->expects($this->once())->method('mapSingle');

        $this->session->groupRepository()->load('staff');
        $this->session->groupRepository()->load('staff');
    }
}
