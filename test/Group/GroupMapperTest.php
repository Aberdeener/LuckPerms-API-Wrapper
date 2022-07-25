<?php

use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Group\Group;
use LuckPermsAPI\Group\GroupMapper;
use LuckPermsAPI\Node\NodeMapper;
use LuckPermsAPI\Node\NodeType;

class GroupMapperTest extends \PHPUnit\Framework\TestCase {

    public function test_group_mapper_can_map_group_data_to_group_objects(): void {
        $groupNodes = [
            [
                'name' => 'test1',
                'displayName' => 'Test 1',
                'weight' => 1,
                'metadata' => [],
                'nodes' => [
                    [
                        'key' => 'permissions.test1',
                        'type' => 'permission',
                        'value' => 'true',
                        'context' => [
                            [
                                'key' => 'world',
                                'value' => 'survival',
                            ],
                            [
                                'key' => 'gamemode',
                                'value' => 'survival',
                            ],
                        ],
                    ],
                    [
                        'key' => 'group.mod',
                        'type' => 'inheritance',
                        'value' => 'true',
                        'context' => [],
                    ]
                ]
            ],
            [
                'name' => 'test2',
                'displayName' => 'Test 2',
                'weight' => 2,
                'metadata' => [],
                'nodes' => [
                    [
                        'key' => 'permissions.test2',
                        'type' => 'permission',
                        'value' => 'false',
                        'context' => [
                            [
                                'key' => 'world',
                                'value' => 'survival',
                            ],
                        ],
                    ],
                ]
            ],
        ];

        $groups = GroupMapper::map($groupNodes);

        $this->assertCount(2, $groupNodes);

        foreach ($groups->all() as $group) {
            $this->assertInstanceOf(Group::class, $group);
        }

        $group = $groups->get('test1');
        $this->assertEquals('test1', $group->name());
        $this->assertEquals('Test 1', $group->displayName());
        $this->assertEquals(1, $group->weight());
        $this->assertCount(0, $group->metadata());
        $this->assertCount(2, $group->rawNodes());
        $permission = $group->permissions()->get(0);
        $this->assertEquals('permissions.test1', $permission->name());
        $this->assertTrue($permission->value());
        $this->assertCount(2, $permission->contexts());
        $context = $permission->contexts()->get(0);
        $this->assertEquals(ContextKey::World, $context->key());
        $this->assertEquals('survival', $context->value());
        $context = $permission->contexts()->get(1);
        $this->assertEquals(ContextKey::GameMode, $context->key());
        $this->assertEquals('survival', $context->value());

        $group = $groups->get('test2');
        $this->assertEquals('test2', $group->name());
        $this->assertEquals('Test 2', $group->displayName());
        $this->assertEquals(2, $group->weight());
        $this->assertCount(0, $group->metadata());
        $this->assertCount(1, $group->rawNodes());
        $permission = $group->permissions()->get(0);
        $this->assertEquals('permissions.test2', $permission->name());
        $this->assertFalse($permission->value());
        $this->assertCount(1, $permission->contexts());
        $context = $permission->contexts()->get(0);
        $this->assertEquals(ContextKey::World, $context->key());
        $this->assertEquals('survival', $context->value());
    }

}
