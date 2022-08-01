<?php

namespace Tests\Node;

use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeMapper;
use LuckPermsAPI\Node\NodeType;
use Tests\TestCase;

class NodeMapperTest extends TestCase {

    public function test_node_mapper_can_map_node_data_to_node_objects(): void {
        $nodeData = [
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

        $nodes = collect($nodeData)->map(function (array $node) {
            return resolve(NodeMapper::class)->map($node);
        });

        $this->assertCount(3, $nodes);

        foreach ($nodes->all() as $node) {
            $this->assertInstanceOf(Node::class, $node);
        }

        $node = $nodes->first();
        $this->assertEquals('permissions.test1', $node->key());
        $this->assertEquals(NodeType::Permission, $node->type());
        $this->assertEquals('true', $node->value());
        $this->assertCount(2, $node->contexts());
        $this->assertEquals(ContextKey::World, $node->contexts()->get(0)->key());
        $this->assertEquals('survival', $node->contexts()->get(0)->value());
        $this->assertEquals(ContextKey::World, $node->contexts()->get(1)->key());
        $this->assertEquals('lobby', $node->contexts()->get(1)->value());
        $this->assertEquals(1111111111, $node->expiry());
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
        ], $node->toArray());

        $node = $nodes->get(1);
        $this->assertEquals('permissions.test2', $node->key());
        $this->assertEquals(NodeType::Permission, $node->type());
        $this->assertEquals('false', $node->value());
        $this->assertCount(1, $node->contexts());
        $this->assertEquals(ContextKey::World, $node->contexts()->get(0)->key());
        $this->assertEquals('survival', $node->contexts()->get(0)->value());
        $this->assertEquals(2222222222, $node->expiry());
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
        ], $node->toArray());

        $node = $nodes->get(2);
        $this->assertEquals('group.mod', $node->key());
        $this->assertEquals(NodeType::Inheritance, $node->type());
        $this->assertEquals('true', $node->value());
        $this->assertCount(0, $node->contexts());
        $this->assertEquals(0, $node->expiry());
        $this->assertSame([
            'key' => 'group.mod',
            'type' => 'inheritance',
            'value' => 'true',
            'context' => [],
            'expiry' => 0,
        ], $node->toArray());
    }
}
