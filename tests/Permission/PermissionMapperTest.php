<?php

use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Node\NodeMapper;
use LuckPermsAPI\Permission\PermissionMapper;

class PermissionMapperTest extends \PHPUnit\Framework\TestCase {

    public function test_permission_mapper_can_map_permission_data_to_permission_objects(): void {
        $permissionNodes = [
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

        $permissions = PermissionMapper::map($permissionNodes);
        $this->assertCount(2, $permissions);

        $permission = $permissions->get(0);
        $this->assertEquals('test.permission1', $permission->name());
        $this->assertTrue($permission->value());
        $this->assertCount(0, $permission->contexts());

        $permission = $permissions->get(1);
        $this->assertEquals('test.permission2', $permission->name());
        $this->assertFalse($permission->value());
        $this->assertCount(1, $permission->contexts());
        $this->assertEquals(ContextKey::World, $permission->contexts()->first()->key());
        $this->assertEquals('hub', $permission->contexts()->first()->value());
    }

}
