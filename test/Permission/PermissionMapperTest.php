<?php

use LuckPermsAPI\Node\NodeMapper;
use LuckPermsAPI\Permission\PermissionMapper;

class PermissionMapperTest extends \PHPUnit\Framework\TestCase {

    public function test_permission_mapper_can_map_permission_data_to_permission_objects() {
        $permissionData = [
            [
                'key' => 'test.permission1',
                'type' => 'permission',
                'value' => 'true',
                'context' => [],
            ],
            [
                'key' => 'test.permission2',
                'type' => 'permission',
                'value' => 'false',
                'context' => [
                    [
                        'key' => 'world',
                        'value' => 'hub',
                    ],
                ],
            ],
        ];

        $permissions = PermissionMapper::map(NodeMapper::map($permissionData)->toArray());
        $this->assertCount(2, $permissions);
        $this->assertEquals('test.permission1', $permissions->get(0)->name());
        $this->assertTrue($permissions->get(0)->value());
        $this->assertEquals('test.permission2', $permissions->get(1)->name());
        $this->assertFalse($permissions->get(1)->value());
    }

}
