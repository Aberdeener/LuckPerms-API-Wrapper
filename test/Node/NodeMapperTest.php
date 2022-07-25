<?php

use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Node\Node;
use LuckPermsAPI\Node\NodeMapper;
use LuckPermsAPI\Node\NodeType;

class NodeMapperTest extends \PHPUnit\Framework\TestCase {

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
            ],
            [
                'key' => 'group.mod',
                'type' => 'inheritance',
                'value' => 'true',
                'context' => [],
            ]
        ];

        $nodes = NodeMapper::map($nodeData);

        $this->assertCount(3, $nodes);

        foreach ($nodes->all() as $node) {
            $this->assertInstanceOf(Node::class, $node);
        }

        $this->assertEquals('permissions.test1', $nodes->get('permissions.test1')->key());
        $this->assertEquals(NodeType::Permission, $nodes->get('permissions.test1')->type());
        $this->assertEquals('true', $nodes->get('permissions.test1')->value());
        $this->assertCount(2, $nodes->get('permissions.test1')->contextSet());
        $this->assertEquals(ContextKey::World, $nodes->get('permissions.test1')->contextSet()->get(0)->key());
        $this->assertEquals('survival', $nodes->get('permissions.test1')->contextSet()->get(0)->value());
        $this->assertEquals(ContextKey::World, $nodes->get('permissions.test1')->contextSet()->get(1)->key());
        $this->assertEquals('lobby', $nodes->get('permissions.test1')->contextSet()->get(1)->value());

        $this->assertEquals('permissions.test2', $nodes->get('permissions.test2')->key());
        $this->assertEquals(NodeType::Permission, $nodes->get('permissions.test2')->type());
        $this->assertEquals('false', $nodes->get('permissions.test2')->value());
        $this->assertCount(1, $nodes->get('permissions.test2')->contextSet());
        $this->assertEquals(ContextKey::World, $nodes->get('permissions.test2')->contextSet()->get(0)->key());
        $this->assertEquals('survival', $nodes->get('permissions.test2')->contextSet()->get(0)->value());

        $this->assertEquals('group.mod', $nodes->get('group.mod')->key());
        $this->assertEquals(NodeType::Inheritance, $nodes->get('group.mod')->type());
        $this->assertEquals('true', $nodes->get('group.mod')->value());
        $this->assertCount(0, $nodes->get('group.mod')->contextSet());
    }
}
