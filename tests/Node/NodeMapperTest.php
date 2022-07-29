<?php

namespace Tests\Node;

use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeMapper;
use LuckPermsAPI\Node\NodeType;
use Tests\TestCase;

class NodeMapperTest extends TestCase {

    public function test_node_mapper_can_map_node_data_to_node_objects(): void {
        $nodes = [
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
                        'key' => 'world',
                        'value' => 'lobby',
                    ],
                ],
                'expiry' => 1111111111,
            ],
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
                'expiry' => 2222222222,
            ],
            [
                'key' => 'group.mod',
                'type' => 'inheritance',
                'value' => 'true',
                'context' => [],
            ]
        ];

        $nodes = resolve(NodeMapper::class)->map($nodes);

        $this->assertCount(3, $nodes);

        foreach ($nodes->all() as $node) {
            $this->assertInstanceOf(Node::class, $node);
        }

        $this->assertEquals('permissions.test1', $nodes->get('permissions.test1')->key());
        $this->assertEquals(NodeType::Permission, $nodes->get('permissions.test1')->type());
        $this->assertEquals('true', $nodes->get('permissions.test1')->value());
        $this->assertCount(2, $nodes->get('permissions.test1')->contexts());
        $this->assertEquals(ContextKey::World, $nodes->get('permissions.test1')->contexts()->get(0)->key());
        $this->assertEquals('survival', $nodes->get('permissions.test1')->contexts()->get(0)->value());
        $this->assertEquals(ContextKey::World, $nodes->get('permissions.test1')->contexts()->get(1)->key());
        $this->assertEquals('lobby', $nodes->get('permissions.test1')->contexts()->get(1)->value());
        $this->assertEquals(1111111111, $nodes->get('permissions.test1')->expiry());
        $this->assertSame([
            'key' => 'permissions.test1',
            'type' => 'permission',
            'value' => 'true',
            'context' => [
                [
                    'key' => 'world',
                    'value' => 'survival',
                ],
                [
                    'key' => 'world',
                    'value' => 'lobby',
                ],
            ],
            'expiry' => 1111111111,
        ], $nodes->get('permissions.test1')->toArray());

        $this->assertEquals('permissions.test2', $nodes->get('permissions.test2')->key());
        $this->assertEquals(NodeType::Permission, $nodes->get('permissions.test2')->type());
        $this->assertEquals('false', $nodes->get('permissions.test2')->value());
        $this->assertCount(1, $nodes->get('permissions.test2')->contexts());
        $this->assertEquals(ContextKey::World, $nodes->get('permissions.test2')->contexts()->get(0)->key());
        $this->assertEquals('survival', $nodes->get('permissions.test2')->contexts()->get(0)->value());
        $this->assertEquals(2222222222, $nodes->get('permissions.test2')->expiry());
        $this->assertSame([
            'key' => 'permissions.test2',
            'type' => 'permission',
            'value' => 'false',
            'context' => [
                [
                    'key' => 'world',
                    'value' => 'survival',
                ],
            ],
            'expiry' => 2222222222,
        ], $nodes->get('permissions.test2')->toArray());

        $this->assertEquals('group.mod', $nodes->get('group.mod')->key());
        $this->assertEquals(NodeType::Inheritance, $nodes->get('group.mod')->type());
        $this->assertEquals('true', $nodes->get('group.mod')->value());
        $this->assertCount(0, $nodes->get('group.mod')->contexts());
        $this->assertEquals(0, $nodes->get('group.mod')->expiry());
        $this->assertSame([
            'key' => 'group.mod',
            'type' => 'inheritance',
            'value' => 'true',
            'context' => [],
            'expiry' => 0,
        ], $nodes->get('group.mod')->toArray());
    }
}
